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
use Webkul\CartRule\Models\CartRule;
use Webkul\Customer\Models\Customer;

class CouponReportController extends Controller
{
    public function index()
    {

        $cart_rules = CartRule::all();




        return view('affiliatemodule.admin.couponreports.index', compact('cart_rules'));
    }

    public function couponsByAffiliate($affiliate)
   {

       $cart_rules = CartRule::where('affiliate_id', $affiliate)
           ->get();

       return view('affiliatemodule.shop.affiliate_coupons', compact('cart_rules', 'affiliate'));
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

                $folderPath='';
                if (auth()->guard('admin')->check()) {
                $folderPath = 'admin';
            }
                // Müşteri mi kontrol et
                elseif (auth()->guard('customer')->check()) {
                $folderPath = 'shop';
            }
            $html = view('affiliatemodule.'.$folderPath.'.partials.coupon-details', compact(
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

            $folderPath = '';
            if (auth()->guard('admin')->check()) {
                $folderPath = 'admin';
            }
            // Müşteri mi kontrol et
            elseif (auth()->guard('customer')->check()) {
                $folderPath = 'shop';
            }
            $html = view('affiliatemodule.' . $folderPath . '.partials.coupon-orders', compact(
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


