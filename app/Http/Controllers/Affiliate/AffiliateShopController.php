<?php

namespace App\Http\Controllers\Affiliate;

use App\Models\Affiliate;

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
use Webkul\Customer\Models\Customer;

class AffiliateShopController extends Controller
{

    public function profile(Affiliate $affiliate) {


        // Tıklama verilerini getir
        $clicks = $affiliate->clicks;

        // Alt temsilcileri getir (eager loading ile)
        $downlineAffiliates = $affiliate->children()->with([
            'customer.orders',
            'children',
            'commissions',
            'generatedCommissions'
        ])->get();

        // Dönüşüm oranını hesapla
        $conversionRate = $this->calculateConversionRate($clicks);

        // Komisyon kurallarını getir
        $rules = $this->getCommissionRules();
        // Maksimum seviyeyi belirle
        $maxLevel = $rules->max('level');


        // Aylık kazanç verilerini hazırla
        $monthlyEarnings = $this->getMonthlyEarnings($affiliate);

        // Toplam değerleri hesapla
        $totalEarnings = $affiliate->commissions->sum('amount');

        return view('affiliatemodule.shop.affiliate_profile', compact(
            'affiliate',
            'clicks',
            'downlineAffiliates',
            'conversionRate',
            'rules',
            'maxLevel',
            'monthlyEarnings',
            'totalEarnings'
        ));

    }
    /**
     * Dönüşüm oranını hesapla
     */
    private function calculateConversionRate($clicks)
    {
        if ($clicks->count() === 0) {
            return 0;
        }

        $convertedClicks = $clicks->where('converted', true)->count();
        return round(($convertedClicks / $clicks->count()) * 100, 2);
    }

    /**
     * Komisyon kurallarını getir
     */
    private function getCommissionRules()
    {
        // CommissionRule modeli varsa
        if (class_exists('\App\Models\CommissionRule')) {
            return CommissionRule::orderBy('level')->get();
        }

        return collect([]); // Boş collection döndür
    }

    /**
     * Aylık kazanç verilerini hazırla (Chart.js için)
     */
    private function getMonthlyEarnings($affiliate)
    {
        $monthsBack = 6; // Son 6 ay
        $earnings = [];

        for ($i = $monthsBack - 1; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();

            $monthlyTotal = $affiliate->commissions()
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->sum('amount');

            $earnings[] = [
                'month' => $month->format('M Y'),
                'amount' => (float) $monthlyTotal
            ];
        }

        return $earnings;
    }

    /**
     * Referans linkini kopyalama için AJAX endpoint
     */
    public function copyReferralLink(Request $request, Affiliate $affiliate)
    {


        if (!$affiliate) {
            return response()->json(['error' => 'Affiliate kaydınız bulunamadı.'], 404);
        }

        $referralLink = url('/ref/' . $affiliate->affiliate_code);

        return response()->json([
            'success' => true,
            'link' => $referralLink,
            'message' => 'Referans linki kopyalandı!'
        ]);
    }

    public function getStats(Request $request, Affiliate $affiliate)
    {


        if (!$affiliate) {
            return response()->json(['error' => 'Affiliate kaydınız bulunamadı.'], 404);
        }

        $period = $request->get('period', 'month'); // day, week, month, year

        switch ($period) {
            case 'day':
                $startDate = Carbon::today();
                break;
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                break;
            case 'year':
                $startDate = Carbon::now()->startOfYear();
                break;
            default:
                $startDate = Carbon::now()->startOfMonth();
        }

        // Bu dönemdeki veriler
        $periodEarnings = $affiliate->commissions()
            ->where('created_at', '>=', $startDate)
            ->sum('amount');

        $periodClicks = $affiliate->clicks()
            ->where('created_at', '>=', $startDate)
            ->count();

        $periodConversions = $affiliate->clicks()
            ->where('created_at', '>=', $startDate)
            ->where('converted', true)
            ->count();

        $periodOrders = $affiliate->customer->orders()
            ->where('created_at', '>=', $startDate)
            ->whereNotIn('status', ['canceled', 'closed'])
            ->sum('base_grand_total_invoiced');

        return response()->json([
            'period' => $period,
            'earnings' => number_format($periodEarnings, 2),
            'clicks' => $periodClicks,
            'conversions' => $periodConversions,
            'orders' => core()->formatPrice($periodOrders),
            'conversion_rate' => $periodClicks > 0 ? round(($periodConversions / $periodClicks) * 100, 2) : 0
        ]);
    }

    /**
     * Komisyon geçmişini filtreli getir
     */
    public function getCommissionHistory(Request $request, Affiliate $affiliate)
    {

        if (!$affiliate) {
            return response()->json(['error' => 'Affiliate kaydınız bulunamadı.'], 404);
        }

        $query = $affiliate->commissions()->with('fromAffiliate.customer');

        // Tarih filtreleri
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        // Seviye filtresi
        if ($request->has('level') && $request->level) {
            $query->where('level', $request->level);
        }

        // Minimum tutar filtresi
        if ($request->has('min_amount') && $request->min_amount) {
            $query->where('amount', '>=', $request->min_amount);
        }

        $commissions = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        return response()->json($commissions);
    }


    /**
     * Tıklama geçmişini getir
     */
    public function getClickHistory(Request $request, Affiliate $affiliate)
    {



        if (!$affiliate) {
            return response()->json(['error' => 'Affiliate kaydınız bulunamadı.'], 404);
        }

        $query = $affiliate->clicks();

        // Tarih filtresi
        if ($request->has('date_filter')) {
            switch ($request->date_filter) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'week':
                    $query->where('created_at', '>=', Carbon::now()->startOfWeek());
                    break;
                case 'month':
                    $query->where('created_at', '>=', Carbon::now()->startOfMonth());
                    break;
            }
        }

        // Dönüşüm filtresi
        if ($request->has('converted') && $request->converted !== '') {
            $query->where('converted', (bool) $request->converted);
        }

        // Cihaz filtresi
        if ($request->has('device_type') && $request->device_type) {
            $query->where('device_type', $request->device_type);
        }

        $clicks = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 20));

        return response()->json($clicks);
    }



    public function myaffiliates() {

        $customer = auth()->guard('customer')->user();
        $affiliate = Affiliate::where('customer_id', $customer->id)->first();

        if (!$affiliate) {
            return redirect()->back()->with('error', 'Temsilci kaydınız bulunamadı.');
        }
        $downlineAffiliates = $affiliate->children()->with([
            'customer.orders',
            'children',
            'commissions',
            'generatedCommissions'
        ])->get();

        if (!$downlineAffiliates) {
            return redirect()->back()->with('error', 'Alt temsilciniz bulunamadı.');
        }

        return view('affiliatemodule.shop.affiliate_downaffiliates', compact(
            'downlineAffiliates',
            'affiliate'
        ));



           }

           private function calculateStats($affiliate)
    {
        $children = $affiliate->children;


        return [
            'totalRepresentatives' => $children->count(),
            'activeRepresentatives' => $children->where('status', 'active')->count(),
            'thisMonthRegistrations' => $children->where('created_at', '>=', now()->startOfMonth())->count(),
            'averageSales' => $children->avg('total_commission_earned') ?? 0,
            'totalCommissions' => $children->commissions()->sum('amount'),
            'totalClicks' => $children->sum(function($child) {
                return $child->total_clicks;
            }),
            'totalConversions' => $children->sum(function($child) {
                return $child->total_conversions;
            }),
        ];
    }

    /**
     * Müşteriden bölge bilgisini al
     */
    private function getRegionFromCustomer($customer)
    {
        if (!$customer) return 'Bilinmiyor';

        // Müşteri modelinde city alanına göre bölge belirleme
        $cityRegionMap = [
            'İstanbul' => 'İstanbul Bölgesi',
            'Ankara' => 'Ankara Bölgesi',
            'İzmir' => 'İzmir Bölgesi',
            'Bursa' => 'Bursa Bölgesi',
            'Antalya' => 'Antalya Bölgesi',
        ];

        return $cityRegionMap[$customer->city] ?? $customer->city . ' Bölgesi';
    }

    /**
     * Durum metnini al
     */
    private function getStatusText($status)
    {
        $statusMap = [
            'active' => 'Aktif',
            'inactive' => 'Pasif',
            'suspended' => 'Askıya Alınmış',
            'pending' => 'Beklemede'
        ];

        return $statusMap[$status] ?? 'Bilinmiyor';
    }

    /**
     * Excel export
     */


    /**
     * Temsilci detaylarını göster
     */
    public function show($id)
    {
        $currentAffiliate = Affiliate::where('customer_id', Auth::id())->first();

        $representative = $currentAffiliate->children()
            ->with(['customer', 'commissions', 'clicks'])
            ->findOrFail($id);

        // Detaylı istatistikler
        $stats = [
            'total_earnings' => $representative->total_earnings,
            'paid_earnings' => $representative->paid_earnings,
            'pending_earnings' => $representative->pending_earnings,
            'this_month_earnings' => $representative->this_month_earnings,
            'total_clicks' => $representative->total_clicks,
            'total_conversions' => $representative->total_conversions,
            'conversion_rate' => $representative->conversion_rate,
            'this_month_clicks' => $representative->this_month_clicks,
            'this_month_conversions' => $representative->this_month_conversions,
            'this_month_conversion_rate' => $representative->this_month_conversion_rate,
            'today_clicks' => $representative->today_clicks,
            'today_conversions' => $representative->today_conversions,
            'revenue_per_click' => $representative->revenue_per_click,
        ];

        // Son 30 günün komisyon geçmişi
        $recentCommissions = $representative->commissions()
            ->with(['order'])
            ->where('created_at', '>=', now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Aylık performans grafiği için veri
        $monthlyPerformance = $this->getMonthlyPerformance($representative);

        return view('affiliate.representative-detail', compact(
            'representative',
            'stats',
            'recentCommissions',
            'monthlyPerformance'
        ));
    }

    /**
     * Aylık performans verilerini al
     */
    private function getMonthlyPerformance($affiliate)
    {
        $months = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = [
                'month' => $date->format('M Y'),
                'earnings' => $affiliate->commissions()
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->sum('amount'),
                'clicks' => $affiliate->clicks()
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->count(),
                'conversions' => $affiliate->clicks()
                    ->whereMonth('created_at', $date->month)
                    ->whereYear('created_at', $date->year)
                    ->converted()
                    ->count(),
            ];
        }
        return $months;
    }


    public function payments()
    {
        $customer = auth()->guard('customer')->user();
        $affiliate = Affiliate::where('customer_id', $customer->id)->first();

        // Eğer affiliate kaydı yoksa 404
        if (!$affiliate) {
            abort(404, 'Affiliate kaydı bulunamadı.');
        }

        $paymentMethods = AffiliatePayment::getPaymentMethods();
        // Filtreleme için query builder
        $paymentsQuery = $affiliate->payments()->latest();

        // Tarih filtreleme
        if (request('start_date')) {
            $paymentsQuery->whereDate('created_at', '>=', request('start_date'));
        }

        if (request('end_date')) {
            $paymentsQuery->whereDate('created_at', '<=', request('end_date'));
        }

        // Ödeme yöntemi filtreleme
        if (request('payment_method')) {
            $paymentsQuery->where('payment_method', request('payment_method'));
        }

        // Sayfalama ile ödemeleri al
        $payments = $paymentsQuery->with(['createdAdmin'])->paginate(15);

        // Bu ay ve bu yıl için istatistikler
        $thisMonthPayments = $affiliate->payments()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $thisYearPayments = $affiliate->payments()
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        // Son ödeme
        $lastPayment = $affiliate->getLastPayment();

        // Cari hesap bakiyesi hesaplama
        $currentBalance = $affiliate->current_account_balance;

        // Son 12 ay için aylık ödeme verisi (grafik için)
        $monthlyPayments = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $amount = $affiliate->payments()
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('amount');

            $monthlyPayments->push([
                'month' => $date->format('M Y'),
                'amount' => $amount
            ]);
        }

        return view('affiliatemodule.shop.affiliate_payments',compact(
            'affiliate',
            'payments',
            'paymentMethods',
            'thisMonthPayments',
            'thisYearPayments',
            'lastPayment',
            'currentBalance',
            'monthlyPayments'
        ));
    }


    // Ödeme detayı modalı için
    public function paymentDetail($paymentId)
    {
        $customer = auth()->guard('customer')->user();
        $affiliate = Affiliate::where('customer_id', $customer->id)->first();

        if (!$affiliate) {
            abort(404, 'Affiliate kaydı bulunamadı.');
        }

        $payment = $affiliate->payments()
            ->with(['createdAdmin'])
            ->findOrFail($paymentId);

        $paymentMethods = [
            'bank_transfer' => 'Banka Havalesi',
            'eft' => 'EFT',
            'papara' => 'Papara',
            'ininal' => 'İninal',
            'crypto' => 'Kripto Para',
            'other' => 'Diğer'
        ];

        return response()->json([
            'payment' => $payment,
            'payment_method_text' => $paymentMethods[$payment->payment_method] ?? $payment->payment_method
        ]);
    }

    // Dashboard için özet veriler
    public function paymentsSummary()
    {
        $customer = auth()->guard('customer')->user();
        $affiliate = Affiliate::where('customer_id', $customer->id)->first();

        if (!$affiliate) {
            return response()->json(['error' => 'Keine Partnerdatensätze gefunden.'], 404);
        }

        $summary = [
            'total_earnings' => $affiliate->total_earnings,
            'total_paid' => $affiliate->total_paid_commission,
            'current_balance' => $affiliate->current_account_balance,
            'payment_count' => $affiliate->payments->count(),
            'last_payment' => $affiliate->getLastPayment(),
            'this_month_payments' => $affiliate->payments()
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount')
        ];

        return response()->json($summary);
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
                return back()->with('error', 'Ungültiger Delegiertencode. Bitte versuchen Sie es erneut.');
            }

            $parentId = $parentAffiliate->id;
            $level = $parentAffiliate->level + 1;
        }

        // Kullanıcının zaten temsilci olup olmadığını kontrol et
        $existingAffiliate = Affiliate::where('customer_id', $customerId)->first();
        if ($existingAffiliate) {
            return back()->with('error', 'Sie sind bereits im Vertretersystem registriert.');
        }
            $customer = Customer::find($customerId);
            if (!$customer) {
                return
                back()->with('error', 'Keine Kundeninformationen gefunden.');
            }
            
        $affiliate = new Affiliate();
        $affiliate->parent_id = $parentId;
        $affiliate->customer_id = $customerId;
        $affiliate->affiliate_code = $affiliateCode;
        $affiliate->level = $level;
        $affiliate->status = "active";
        $affiliate->joined_at = Carbon::now('Europe/Berlin');
        $affiliate->save();



        $customer->customer_group_id = 4;
        $customer->save();

        return back()->with('success', 'Ihre Registrierung im Vertretersystem wurde erfolgreich abgeschlossen.');

    } catch (\Exception $e) {
        Log::error('Temsilci kayıt hatası: ' . $e->getMessage());

        return back()->with('error', 'Bei der Registrierung ist ein Fehler aufgetreten. Bitte versuchen Sie den Sponsorcode erneut.');
    }
}

    /**
     * Benzersiz bir affiliate kodu oluşturur
     * Format: LNAFF{müşteri_id}_{rasgele_karakterler}
     *
     * @param int $customerId Müşteri ID'si
     * @return string Benzersiz affiliate kodu
     */
    public function generateUniqueAffiliateCode($customerId)
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


}
