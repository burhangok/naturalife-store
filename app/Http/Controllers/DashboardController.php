<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


use App\Models\Affiliate;
use App\Models\AffiliateCommission;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    /**
     * Affiliate dashboard ana sayfası
     */
    public function index()
    {
        $dashboardData = $this->getDashboardData();

        return view('affiliatemodule.admin.dashboard', $dashboardData);
    }

    /**
     * Dashboard verilerini hazırla
     */
    private function getDashboardData()
    {
        // Son 7 günün başlangıç tarihi
        $lastWeekStart = Carbon::now()->subDays(6)->startOfDay();
        $today = Carbon::now()->endOfDay();

        // 1. Toplam affiliate sayısı (aktif olanlar)
        $totalAffiliates = Affiliate::where('status', 'active')->count();

        // 2. Son 7 günlük toplam satış tutarı
        $lastWeekSales = AffiliateCommission::with('order')
            ->whereBetween('created_at', [$lastWeekStart, $today])
            ->get()
            ->sum(function ($commission) {
                return $commission->order ? $commission->order->grand_total : 0;
            });

        // 3. Son 7 günlük toplam komisyon tutarı
        $lastWeekCommission = AffiliateCommission::whereBetween('created_at', [$lastWeekStart, $today])
            ->sum('amount');

        // 4. Son 10 komisyon listesi (detaylı bilgilerle)
        $recentCommissions = AffiliateCommission::with([
            'affiliate',
            'fromAffiliate',
            'order:id,grand_total,status'
        ])
            ->latest()
            ->limit(10)
            ->get();

        // 5. Ek istatistikler
        $additionalStats = $this->getAdditionalStats($lastWeekStart, $today);

        return [
            'totalAffiliates' => $totalAffiliates,
            'lastWeekSales' => $lastWeekSales,
            'lastWeekCommission' => $lastWeekCommission,
            'recentCommissions' => $recentCommissions,
            'additionalStats' => $additionalStats
        ];
    }

    /**
     * Ek istatistikler
     */
    private function getAdditionalStats($lastWeekStart, $today)
    {
        return [
            // Bu ay toplam komisyon
            'thisMonthCommission' => AffiliateCommission::whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])
                ->sum('amount'),

            // Bugünkü komisyonlar
            'todayCommissions' => AffiliateCommission::whereDate('created_at', Carbon::today())
                ->sum('amount'),

            // Seviye bazında komisyon dağılımı
            'commissionsByLevel' => AffiliateCommission::selectRaw('level, SUM(amount) as total_amount, COUNT(*) as count')
                ->groupBy('level')
                ->orderBy('level')
                ->get(),

            // Son 7 günlük günlük komisyon detayları (grafik için)
            'dailyCommissions' => AffiliateCommission::selectRaw('DATE(created_at) as date, SUM(amount) as total_amount, COUNT(*) as count')
                ->whereBetween('created_at', [$lastWeekStart, $today])
                ->groupBy('date')
                ->orderBy('date')
                ->get(),

            // Toplam affiliate sayısı (tüm durumlar)
            'totalAffiliatesAll' => Affiliate::count(),

            // En çok komisyon kazanan affiliateler (top 5)
            'topEarningAffiliates' => AffiliateCommission::with('affiliate')
                ->selectRaw('affiliate_id, SUM(amount) as total_earnings')
                ->groupBy('affiliate_id')
                ->orderByDesc('total_earnings')
                ->limit(5)
                ->get(),

            // Toplam komisyon tutarı
            'totalCommissions' => AffiliateCommission::sum('amount'),

            // Bu haftaki toplam komisyon sayısı
            'thisWeekCommissionCount' => AffiliateCommission::whereBetween('created_at', [$lastWeekStart, $today])
                ->count()
        ];
    }

    /**
     * AJAX ile dashboard verilerini güncelle
     */
    public function refreshDashboard(Request $request)
    {
        $dashboardData = $this->getDashboardData();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $dashboardData
            ]);
        }

        return redirect()->back()->with('success', 'Dashboard verileri güncellendi.');
    }

    /**
     * Komisyon detaylarını getir
     */
    public function getCommissionDetails($id)
    {
        $commission = AffiliateCommission::with([
            'affiliate:id,name,email,phone',
            'fromAffiliate:id,name,email',
            'order:id,grand_total,created_at'
        ])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'commission' => $commission
        ]);
    }

    /**
     * Haftalık komisyon grafiği verisi
     */
    public function getWeeklyCommissionChart()
    {
        $weeklyData = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dayCommissions = AffiliateCommission::whereDate('created_at', $date)
                ->sum('amount');

            $weeklyData->push([
                'date' => $date->format('Y-m-d'),
                'day' => $date->format('l'),
                'amount' => $dayCommissions
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $weeklyData
        ]);
    }

    /**
     * Komisyon filtreli liste
     */
    public function getFilteredCommissions(Request $request)
    {
        $query = AffiliateCommission::with([
            'affiliatel',
            'fromAffiliate',
            'order:id,grand_total'
        ]);

        // Tarih aralığı filtresi
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Seviye filtresi
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        $commissions = $query->latest()
            ->paginate($request->get('per_page', 15));

        return response()->json([
            'success' => true,
            'commissions' => $commissions
        ]);
    }
    public function affiliateDashboard()
    {
        return view('affiliatemodule.shop.affiliate_dashboard', );
    }


}
