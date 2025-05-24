<?php

namespace App\Http\Middleware;

use App\Models\AffiliateClick;
use Closure;
use Illuminate\Http\Request;
use App\Services\AffiliateTrackingService;
use App\Models\Affiliate;
use Illuminate\Support\Facades\Cookie;

class TrackAffiliateClick
{
    private function recordClick(Request $request, Affiliate $affiliate)
    {
        // Aynı session ve IP'den gelen tekrar clickleri engelle (24 saat içinde)
        $existingClick = AffiliateClick::where('affiliate_id', $affiliate->id)
            ->where('session_id', session()->getId())
            ->where('ip_address', $request->ip())
            ->where('created_at', '>=', now()->subDay())
            ->first();

        if (!$existingClick) {
            AffiliateClick::create([
                'affiliate_id' => $affiliate->id,
                'session_id' => session()->getId(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referrer_url' => $request->headers->get('referer'),
                'landing_page' => $request->url(),
            ]);
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Affiliate kodu var mı kontrol et
        if ($request->has('ref')) {
            $affiliateCode = $request->get('ref');
            $affiliate = Affiliate::where('affiliate_code', $affiliateCode)
                ->where('status', 'active')
                ->first();

            if ($affiliate) {
                // Session'da affiliate bilgisini sakla
                session(['affiliate_id' => $affiliate->id]);
                session(['affiliate_code' => $affiliateCode]);

                // Click'i kaydet
                $this->recordClick($request, $affiliate);
            }
        }

        return $next($request);
    }
}
