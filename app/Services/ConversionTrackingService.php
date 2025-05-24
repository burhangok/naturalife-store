<?php

namespace App\Services;

use App\Models\Affiliate;
use App\Models\AffiliateClick;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DeviceDetector\DeviceDetector;
use Illuminate\Support\Facades\Http;
use Webkul\Sales\Models\Order;

class ConversionTrackingService
{
    public function trackConversion(Order $order)
    {
        // Session'da affiliate ID var mı kontrol et
        $affiliateId = session('affiliate_id');

        if (!$affiliateId) return;

        $affiliate = Affiliate::find($affiliateId);
        if (!$affiliate) return;

        // Bu session'dan gelen son click'i bul
        $click = AffiliateClick::where('affiliate_id', $affiliateId)
            ->where('session_id', session()->getId())
            ->where('converted', false)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($click) {
            // Click'i dönüşüm olarak işaretle
            $click->update([
                'converted' => true,
                'order_id' => $order->id,
                'conversion_date' => now()
            ]);

            // Komison oluştur
            $this->createCommission($order, $affiliate);

            // Session'ı temizle
            session()->forget(['affiliate_id', 'affiliate_code']);
        }
    }

    public function getConversionStats(Affiliate $affiliate, $period = null)
    {
        $clicksQuery = $affiliate->clicks();
        $conversionsQuery = $affiliate->clicks()->converted();

        // Dönem filtresi
        if ($period) {
            switch ($period) {
                case 'today':
                    $clicksQuery->today();
                    $conversionsQuery->today();
                    break;
                case 'this_month':
                    $clicksQuery->thisMonth();
                    $conversionsQuery->thisMonth();
                    break;
                case 'last_30_days':
                    $clicksQuery->where('created_at', '>=', now()->subDays(30));
                    $conversionsQuery->where('created_at', '>=', now()->subDays(30));
                    break;
            }
        }

        $totalClicks = $clicksQuery->count();
        $totalConversions = $conversionsQuery->count();
        $conversionRate = $totalClicks > 0 ? round(($totalConversions / $totalClicks) * 100, 2) : 0;

        return [
            'total_clicks' => $totalClicks,
            'total_conversions' => $totalConversions,
            'conversion_rate' => $conversionRate,
            'revenue' => $affiliate->commissions()->sum('amount'),
            'revenue_per_click' => $totalClicks > 0 ? round($affiliate->commissions()->sum('amount') / $totalClicks, 4) : 0
        ];
    }


}
