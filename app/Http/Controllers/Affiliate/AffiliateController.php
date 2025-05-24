<?php

namespace App\Http\Controllers\Affiliate;

use App\Models\Affiliate;
use App\Models\AffiliateClick;
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
        $affiliates = Affiliate::with('customer', 'children')

            ->orderBy('id', 'desc')->get();



        return view('affiliatemodule.admin.affiliates.index', compact('affiliates'));
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
        $customerId = auth()->guard('customer')->user()->id;

        // Generate unique affiliate code
        $affiliateCode = $this->generateUniqueAffiliateCode($customerId);

        // Calculate level based on parent
        $level = 0;
        $parentId = null;

        // Affiliate kodu kontrolü
        if ($request->affiliate_code != 'AFFLN_O01') {
            $parentAffiliate = Affiliate::where('affiliate_code', $request->affiliate_code)->first();

            if (!$parentAffiliate) {
                return back()->with('error', 'Geçersiz temsilci kodu. Lütfen tekrar deneyin.');
            }

            $parentId = $parentAffiliate->id;
            $level = $parentAffiliate->level + 1;
        }

        // Kullanıcının zaten temsilci olup olmadığını kontrol et
        $existingAffiliate = Affiliate::where('customer_id', $customerId)->first();
        if ($existingAffiliate) {
            return back()->with('error', 'Zaten temsilcilik sistemine kayıtlısınız.');
        }

        $affiliate = new Affiliate();
        $affiliate->parent_id = $parentId;
        $affiliate->customer_id = $customerId;
        $affiliate->affiliate_code = $affiliateCode;
        $affiliate->level = $level;
        $affiliate->status = "active";
        $affiliate->joined_at = Carbon::now('Europe/Berlin');
        $affiliate->save();

        $customer = Customer::find($customerId);
        if (!$customer) {
            return back()->with('error', 'Müşteri bilgisi bulunamadı.');
        }

        $customer->customer_group_id = 4;
        $customer->save();

        return back()->with('success', 'Temsilcilik sistemine kaydınız başarıyla tamamlanmıştır.');

    } catch (\Exception $e) {
        Log::error('Temsilci kayıt hatası: ' . $e->getMessage());
        return back()->with('error', 'Kayıt işlemi sırasında bir hata oluştu. Lütfen daha sonra tekrar deneyin.');
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
}
