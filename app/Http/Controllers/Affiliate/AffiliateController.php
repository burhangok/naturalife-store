<?php

namespace App\Http\Controllers\Affiliate;

use App\Models\Affiliate;
use App\Models\AffiliateClick;
use App\Models\AffiliatePayment;
use App\Models\CommissionRule;
use App\Models\User;
use App\Services\AffiliateTrackingService;
use Carbon\Carbon;
use Cookie;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Log;
use Webkul\CartRule\Models\CartRule;
use Webkul\Customer\Models\Customer;

class AffiliateController extends Controller
{
    /**
     * Display a listing of the affiliates.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $existingAffiliateCustomerIds = Affiliate::pluck('customer_id')->toArray();
        $customers = Customer::whereNotIn('id', $existingAffiliateCustomerIds)
            ->orderBy('first_name')
            ->get();
        $affiliates = Affiliate::with('customer', 'children')

            ->orderBy('id', 'desc')->get();



        return view('affiliatemodule.admin.affiliates.index', compact('affiliates', 'customers'));
    }

    /**
     * Show the form for creating a new affiliate.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Affiliate::with('customer', 'children')->where('status', 'active')->get();
        return view('affiliatemodule.admin.affiliates.create', compact('parents'));
    }


    public function store(Request $request)
    {
        try {
            // Kullanıcının zaten temsilci olup olmadığını kontrol et
            $existingAffiliate = Affiliate::where('affiliate_code', $request->affiliate_code)->first();
            if ($existingAffiliate) {
                return back()->with('error', 'Bu temsilci kodu kullanılmaktadır. Başka bir kod deneyiniz!');
            }


            if (!$request->affiliate_code)
                $request->affiliate_code = $this->generateUniqueAffiliateCode($request->customer_id);

            $level = 0;

            if ($request->parent_id) {
                $parentAffiliate = Affiliate::find($request->parent_id);
                if ($parentAffiliate) {
                    $level = $parentAffiliate->level + 1;
                } else {
                    return back()->with('error', 'Seçilen üst temsilci bulunamadı.');
                }
            }


            $affiliate = new Affiliate();
            $affiliate->parent_id = $request->parent_id ?: null;
            $affiliate->customer_id = $request->customer_id;
            $affiliate->affiliate_code = $request->affiliate_code;
            $affiliate->level = $level;
            $affiliate->status = "active";
            $affiliate->joined_at = Carbon::now('Europe/Berlin');
            $affiliate->save();

            $customer = Customer::find($request->customer_id);
            if (!$customer) {
                return back()->with('error', 'Müşteri bilgisi bulunamadı.');
            }

            $customer->customer_group_id = 4;
            $customer->save();

            return back()->with('success', 'Temsilcilik sistemine kaydınız başarıyla tamamlanmıştır.');

        } catch (\Exception $e) {
            Log::error('Temsilci kayıt hatası: ' . $e->getMessage());
            return back()->with('error', 'Kayıt işlemi sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyin. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified affiliate.
     *
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Http\Response
     */
    public function show(Affiliate $affiliate)
    {
        // Get children affiliates
        $children = Affiliate::where('parent_id', $affiliate->id)->get();

        return view('affiliatemodule.admin.affiliates.show', compact('affiliate', 'children'));
    }

    public function edit($id)
    {
        try {
            // Detaylı hata ayıklama için log
            Log::info("Affiliate edit method called with ID: " . $id);

            $paymentMethods = AffiliatePayment::getPaymentMethods();
            // Affiliate'i ve ilişkili verileri getir
            $affiliate = Affiliate::with([
                'customer',
                'children',
                'parent',
                'commissions' => function ($query) {
                    $query->latest()->limit(10);
                }
            ])->findOrFail($id);

            // Log affiliate details
            Log::info("Affiliate found: ", [
                'id' => $affiliate->id,
                'name' => $affiliate->name,
                'email' => $affiliate->email
            ]);

            // Default değerler
            $rules = collect(); // Boş koleksiyon
            $downlineAffiliates = collect(); // Boş koleksiyon
            $clicks = collect(); // Boş koleksiyon
            $total = 0;
            $converted = 0;
            $conversionRate = '0%';

            // Komisyon kurallarını getir (varsa)
            if (class_exists(CommissionRule::class)) {
                $rules = CommissionRule::with('creator', 'updater')
                    ->orderBy('level')
                    ->get();
            }

            // Alt affiliate'leri getir (varsa)
            $downlineAffiliates = Affiliate::where('parent_id', $affiliate->id)
                ->with('customer')
                ->get();

            // Tıklamaları getir (varsa)
            $clicks = AffiliateClick::where('affiliate_id', $affiliate->id)
                ->orderByDesc('created_at')
                ->get();

            // Tıklama istatistikleri
            $total = $clicks->count();
            $converted = $clicks->where('converted', true)->count();
            $conversionRate = $total
                ? round($converted / $total * 100, 1) . '%'
                : '0%';





            // View'a gönderilecek veriler
            $viewData = array_merge(
                compact(
                    'affiliate',
                    'downlineAffiliates',
                    'rules',
                    'paymentMethods',
                    'clicks',
                    'conversionRate',
                    'total',
                    'converted'
                ),

            );

            // Görünüm yolunu kontrol et
            $view = request()->input('_config.view', 'affiliatemodule.admin.affiliates.edit');

            // Log view path
            Log::info("Rendering view: " . $view);

            return view($view, $viewData);

        } catch (\Exception $e) {
            // Tüm hataları logla
            Log::error("Affiliate Edit Error: " . $e->getMessage());
            Log::error($e->getTraceAsString());

            // Hata sayfası veya ana sayfaya yönlendirme
            return redirect()->route('admin.affiliatemodule.admin.affiliates.index')
                ->with('error', 'Affiliate bulunamadı veya bir hata oluştu: ' . $e->getMessage());
        }
    }

    // prepareAffiliatePaymentData metodu önceki örnekteki gibi kalacak
    private function prepareAffiliatePaymentData(Affiliate $affiliate)
    {
        try {

            // Zaman periyodunu belirle
            $period = request('period', 'all');

            // Tarih aralıklarını ayarla
            $now = now();
            $startDate = null;
            $endDate = $now;

            switch ($period) {
                case 'month':
                    $startDate = $now->startOfMonth();
                    break;
                case 'last_month':
                    $startDate = $now->copy()->subMonth()->startOfMonth();
                    $endDate = $now->copy()->subMonth()->endOfMonth();
                    break;
                case 'all':
                    $startDate = null; // Tüm zamanlar için başlangıç tarihi yok
                    break;
                default:
                    $startDate = $now->startOfMonth();
            }

            // Varsayılan boş değerler
            $commissions = collect();
            $totalEarnings = 0;
            $currentMonthEarnings = 0;
            $totalEarningsChange = 0;
            $weeklyChange = 0;
            $totalPaid = 0;
            $lastPaymentDate = null;

            // Affiliate'in komisyonları varsa hesapla
            if ($affiliate->commissions()->exists()) {
                // Sayfalanmış komisyonları getir
                $commissions = $affiliate->commissions()
                    ->with(['fromAffiliate:id,name'])
                    ->when($startDate, function ($query) use ($startDate, $endDate) {
                        return $query->whereBetween('created_at', [$startDate, $endDate]);
                    })
                    ->orderBy('created_at', 'desc')
                    ->get();

                // Toplam kazançları hesapla
                $totalEarnings = $affiliate->commissions()
                    ->whereIn('status', ['approved', 'paid'])
                    ->sum('amount');

                // Cari ay kazançları
                $currentMonthEarnings = $affiliate->commissions()
                    ->whereIn('status', ['approved', 'paid'])
                    ->whereMonth('created_at', $now->month)
                    ->whereYear('created_at', $now->year)
                    ->sum('amount');

                // Önceki ay kazançları (karşılaştırma için)
                $previousMonthEarnings = $affiliate->commissions()
                    ->whereIn('status', ['approved', 'paid'])
                    ->whereMonth('created_at', $now->copy()->subMonth()->month)
                    ->whereYear('created_at', $now->copy()->subMonth()->year)
                    ->sum('amount');

                // Kazanç değişim yüzdesi
                $totalEarningsChange = $previousMonthEarnings > 0
                    ? round((($currentMonthEarnings - $previousMonthEarnings) / $previousMonthEarnings) * 100)
                    : 0;

                // Haftalık kazanç değişimi
                $thisWeekEarnings = $affiliate->commissions()
                    ->whereIn('status', ['approved', 'paid'])
                    ->whereBetween('created_at', [
                        $now->copy()->startOfWeek(),
                        $now->copy()->endOfWeek()
                    ])
                    ->sum('amount');

                $lastWeekEarnings = $affiliate->commissions()
                    ->whereIn('status', ['approved', 'paid'])
                    ->whereBetween('created_at', [
                        $now->copy()->subWeek()->startOfWeek(),
                        $now->copy()->subWeek()->endOfWeek()
                    ])
                    ->sum('amount');

                // Haftalık değişim yüzdesi
                $weeklyChange = $lastWeekEarnings > 0
                    ? round((($thisWeekEarnings - $lastWeekEarnings) / $lastWeekEarnings) * 100)
                    : 0;

                // Toplam ödenen tutar
                $totalPaid = $affiliate->commissions()
                    ->where('status', 'paid')
                    ->sum('amount');

                // Son ödeme tarihi
                $lastPaymentDate = $affiliate->commissions()
                    ->where('status', 'paid')
                    ->latest('paid_at')
                    ->value('paid_at');

                // Son ödeme tarihini Carbon örneği olarak al
                $lastPaymentDate = $lastPaymentDate
                    ? Carbon::parse($lastPaymentDate)
                    : null;

            }


            return [
                'commissions' => $commissions,
                'totalEarnings' => $totalEarnings,
                'currentMonthEarnings' => $currentMonthEarnings,
                'totalEarningsChange' => $totalEarningsChange,
                'weeklyChange' => $weeklyChange,
                'totalPaid' => $totalPaid,
                'lastPaymentDate' => $lastPaymentDate,
                'selectedPeriod' => $period
            ];
        } catch (\Exception $e) {
            // Hata durumunda log at ve varsayılan değerler döndür
            Log::error("Prepare Payment Data Error: " . $e->getMessage());

            return [
                'commissions' => collect(),
                'totalEarnings' => 0,
                'currentMonthEarnings' => 0,
                'totalEarningsChange' => 0,
                'weeklyChange' => 0,
                'totalPaid' => 0,
                'lastPaymentDate' => null,
                'selectedPeriod' => $period
            ];
        }
    }

    /**
     * Update the specified affiliate in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Affiliate $affiliate)
    {
        $request->validate([
            'parent_id' => 'nullable|exists:affiliates,id',
            'status' => 'required|in:active,inactive,suspended',
            'description' => 'nullable|string',
        ]);

        // Prevent circular parent references
        if ($request->parent_id && $this->wouldCreateCircularReference($affiliate, $request->parent_id)) {
            return redirect()->back()
                ->with('error', 'Bu üst affiliate seçimi döngüsel bir referans oluşturur.')
                ->withInput();
        }

        // Calculate level based on parent
        $level = 0;
        if ($request->parent_id) {
            $parentAffiliate = Affiliate::find($request->parent_id);
            if ($parentAffiliate) {
                $level = $parentAffiliate->level + 1;
            }
        }

        $affiliate->parent_id = $request->parent_id;
        $affiliate->level = $level;
        $affiliate->status = $request->status;
        $affiliate->description = $request->description;
        $affiliate->updated_user_id = auth()->guard('admin')->user()->id;
        $affiliate->save();

        return redirect()->route('affiliatemodule.affiliates.index')
            ->with('success', 'Affiliate başarıyla güncellendi.');
    }

    /**
     * Remove the specified affiliate from storage.
     *
     * @param  \App\Models\Affiliate  $affiliate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Affiliate $affiliate)
    {
        // Check if affiliate has children
        $hasChildren = Affiliate::where('parent_id', $affiliate->id)->exists();

        if ($hasChildren) {
            return redirect()->route('affiliatemodule.admin.affiliates.index')
                ->with('error', 'Bu affiliate silinemez çünkü alt affiliateleri bulunmaktadır.');
        }

        $affiliate->delete();

        return redirect()->route('affiliatemodule.admin.affiliates.index')
            ->with('success', 'Affiliate başarıyla silindi.');
    }

    /**
     * Benzersiz bir affiliate kodu oluşturur
     * Format: LNAFF{müşteri_id}_{rasgele_karakterler}
     *
     * @param int $customerId Müşteri ID'si
     * @return string Benzersiz affiliate kodu
     */
    private function generateUniqueAffiliateCode($customerId)
    {
        // Prefix oluşturuluyor: LNAFF{müşteri_id}_
        $prefix = "AFF{$customerId}_";

        // Rasgele karakter uzunluğu (toplam uzunluğun sabit kalması için)
        $randomLength = 4;

        do {
            // Rasgele karakterler oluştur
            $randomPart = strtoupper(Str::random($randomLength));

            // Tam kodu birleştir
            $code = $prefix . $randomPart;

            // Kodun veritabanında var olup olmadığını kontrol et
        } while (Affiliate::where('affiliate_code', $code)->exists());

        return $code;
    }
    /**
     * Check if changing the parent would create a circular reference.
     *
     * @param  \App\Models\Affiliate  $affiliate
     * @param  int  $newParentId
     * @return bool
     */
    private function wouldCreateCircularReference($affiliate, $newParentId)
    {
        $parentId = $newParentId;

        while ($parentId !== null) {
            if ($parentId == $affiliate->id) {
                return true;
            }

            $parent = Affiliate::find($parentId);
            if (!$parent) {
                break;
            }

            $parentId = $parent->parent_id;
        }

        return false;
    }




    /**
     * Kupon detaylarını modal için döndürür
     */
    public function getCouponDetails($id)
    {
        try {
            $coupon = CartRule::with(['orders', 'channels', 'customer_groups'])->findOrFail($id);

            // Kupon istatistikleri
            $totalOrders = $coupon->orders->count();
            $totalRevenue = $coupon->orders->sum('grand_total');
            $totalDiscount = $coupon->orders->sum('discount_amount');
            $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

            // Son kullanım tarihleri
            $lastUsed = $coupon->orders->max('created_at');
            $firstUsed = $coupon->orders->min('created_at');

            // Aylık kullanım istatistikleri
            $monthlyStats = $coupon->orders()
                ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as count, SUM(grand_total) as total')
                ->groupByRaw('YEAR(created_at), MONTH(created_at)')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->limit(6)
                ->get();

            $html = view('affiliatemodule.admin.affiliates.partials.coupon-details', compact(
                'coupon',
                'totalOrders',
                'totalRevenue',
                'totalDiscount',
                'avgOrderValue',
                'lastUsed',
                'firstUsed',
                'monthlyStats'
            ))->render();

            return response($html);

        } catch (\Exception $e) {
            return response('<div class="alert alert-danger">Kupon detayları yüklenirken hata oluştu: ' . $e->getMessage() . '</div>', 500);
        }
    }

    /**
     * Kupona ait siparişleri modal için döndürür
     */
    public function getCouponOrders($id)
    {
        try {
            $coupon = CartRule::findOrFail($id);

            $orders = $coupon->orders()
                ->with(['customer', 'items.product'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            // Siparişlerin toplam istatistikleri
            $totalOrders = $orders->total();
            $totalRevenue = $coupon->orders->sum('grand_total');
            $totalDiscount = $coupon->orders->sum('discount_amount');
            $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

            // Commission hesaplama (örnek: %6 komisyon)
            $commissionRate = 0.06;
            $totalCommission = $totalRevenue * $commissionRate;

            // Müşteri analizi
            $uniqueCustomers = $coupon->orders()->distinct('customer_id')->count('customer_id');
            $repeatCustomers = $coupon->orders()
                ->selectRaw('customer_id, COUNT(*) as order_count')
                ->groupBy('customer_id')
                ->having('order_count', '>', 1)
                ->count();

            // En çok satın alan müşteriler
            $topCustomers = $coupon->orders()
                ->selectRaw('customer_id, customer_email, customer_first_name, customer_last_name, COUNT(*) as order_count, SUM(grand_total) as total_spent')
                ->groupBy('customer_id', 'customer_email', 'customer_first_name', 'customer_last_name')
                ->orderBy('total_spent', 'desc')
                ->limit(5)
                ->get();

            $html = view('affiliatemodule.admin.affiliates.partials.coupon-orders', compact(
                'coupon',
                'orders',
                'totalOrders',
                'totalRevenue',
                'totalDiscount',
                'avgOrderValue',
                'totalCommission',
                'commissionRate',
                'uniqueCustomers',
                'repeatCustomers',
                'topCustomers'
            ))->render();

            return response($html);

        } catch (\Exception $e) {
            return response('<div class="alert alert-danger">Sipariş listesi yüklenirken hata oluştu: ' . $e->getMessage() . '</div>', 500);
        }
    }

    /**
     * Kupon performans grafiği için veri döndürür
     */
    public function getCouponChart($id)
    {
        try {
            $coupon = CartRule::findOrFail($id);

            // Son 30 günlük kullanım verileri
            $chartData = $coupon->orders()
                ->selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(grand_total) as revenue')
                ->where('created_at', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date')
                ->get()
                ->map(function ($item) {
                    return [
                        'date' => $item->date,
                        'orders' => $item->orders,
                        'revenue' => (float) $item->revenue
                    ];
                });

            return response()->json($chartData);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Chart data could not be loaded'], 500);
        }
    }

    public function getAffiliateCouponStats($affiliateId)
    {
        try {
            $affiliate = Affiliate::findOrFail($affiliateId);

            // Kupon istatistikleri
            $totalCoupons = $affiliate->coupons()->count();
            $activeCoupons = $affiliate->coupons()->where('status', 1)->count();
            $expiredCoupons = $affiliate->coupons()
                ->where('ends_till', '<', now())
                ->count();

            // Sipariş ve gelir istatistikleri
            $totalOrders = 0;
            $totalRevenue = 0;
            $totalDiscount = 0;
            $thisMonthOrders = 0;
            $thisMonthRevenue = 0;

            foreach ($affiliate->coupons as $coupon) {
                $totalOrders += $coupon->orders()->count();
                $totalRevenue += $coupon->orders()->sum('grand_total');
                $totalDiscount += $coupon->orders()->sum('discount_amount');

                $thisMonthOrders += $coupon->orders()
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count();

                $thisMonthRevenue += $coupon->orders()
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->sum('grand_total');
            }

            // Komisyon hesaplama
            $commissionRate = 0.06; // %6 komisyon
            $totalCommission = $totalRevenue * $commissionRate;
            $thisMonthCommission = $thisMonthRevenue * $commissionRate;

            return response()->json([
                'totalCoupons' => $totalCoupons,
                'activeCoupons' => $activeCoupons,
                'expiredCoupons' => $expiredCoupons,
                'totalOrders' => $totalOrders,
                'totalRevenue' => $totalRevenue,
                'totalDiscount' => $totalDiscount,
                'totalCommission' => $totalCommission,
                'thisMonthOrders' => $thisMonthOrders,
                'thisMonthRevenue' => $thisMonthRevenue,
                'thisMonthCommission' => $thisMonthCommission
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'İstatistikler yüklenirken hata oluştu'], 500);
        }
    }
}
