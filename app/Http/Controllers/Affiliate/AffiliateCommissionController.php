<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use App\Models\AffiliateCommission;
use App\Models\Affiliate;
use App\Models\CommissionRule;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AffiliateCommissionController extends Controller
{
    /**
     * Komisyon listesini görüntüle
     */
    public function index(Request $request)
    {
        $commissions = AffiliateCommission::with(['affiliate', 'order', 'fromAffiliate'])
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->affiliate_id, function ($query, $affiliateId) {
                return $query->where('affiliate_id', $affiliateId);
            })
            ->latest()
            ->paginate(15);

        return view('affiliatemodule.admin.commissions.index', compact('commissions'));
    }

    /**
     * Komisyon detayını görüntüle
     */
    public function edit(AffiliateCommission $commission)
    {
        $commission->load(['affiliate', 'order', 'fromAffiliate']);

        return view('affiliatemodule.admin.commissions.edit', compact('commission'));
    }

    /**
     * Komisyonu güncelle (admin için)
     */
    public function update(Request $request, AffiliateCommission $commission)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,paid,rejected',
            'description' => 'nullable|string|max:500',
        ]);

        if ($validated['status'] == 'paid' && $commission->status != 'paid') {
            $validated['paid_at'] = now();
        }

        $commission->update($validated);

        return redirect()->route('affiliatemodule.admin.affiliate.commissions.index', $commission)
            ->with('success', 'Komisyon durumu başarıyla güncellendi.');
    }

    /**
     * Affiliate paneli için komisyon listesi
     */
    public function affiliateCommissions()
    {

        $customerId = auth()->guard('customer')->user()->id;


        $affiliate = Affiliate::where('customer_id', $customerId)->first();

        if (!$affiliate) {
            abort(403, 'Affiliate hesabınız bulunmamaktadır.');
        }

        $commissions = AffiliateCommission::with(['order', 'fromAffiliate'])
            ->where('affiliate_id', $affiliate->id)
            ->latest()
            ->paginate(15);

        $totalEarnings = AffiliateCommission::where('affiliate_id', $affiliate->id)
            ->where('status', 'paid')
            ->sum('amount');

        $pendingEarnings = AffiliateCommission::where('affiliate_id', $affiliate->id)
            ->whereIn('status', ['pending', 'approved'])
            ->sum('amount');

        return view('affiliatemodule.admin.commissions.index', compact(
            'commissions',
            'totalEarnings',
            'pendingEarnings'
        ));
    }

    /**
     * Sipariş tamamlandıktan sonra affiliate komisyonlarını oluştur
     *

     * @return void
     */
public static function createCommissions(\Webkul\Sales\Models\Order $order)
{
    $customerId = $order->customer->id;
    $affiliate = Affiliate::where('customer_id', $customerId)->first();

    // Eğer siparişteki kullanıcının bir affiliate kaydı yoksa işlem yapma
    if (!$affiliate) {
        return;
    }



    DB::transaction(function () use ($order, $affiliate) {
        // Sipariş veren kişinin affiliate ID'si - sadece parent zinciri için kullanılacak
        $orderAffiliateId = $affiliate->id;
        $level = 1;

        // Siparişin uygun tutarını al (vergi hariç vs.)
        $commissionalAmount = $order->grand_total - $order->shipping_amount;

        // Aktif komisyon kurallarını al
        $commissionRules = CommissionRule::where('is_active', 1)->orderBy('level')->get();

        // Kurallar yoksa işlem yapma
        if ($commissionRules->isEmpty()) {
            return;
        }

        // Maksimum seviyeyi belirle
        $maxLevel = $commissionRules->max('level');

        // Sipariş veren kişinin üst affiliate'i ile başla
        $currentAffiliateId = $affiliate->parent_id;
        $currentFromAffiliateId = $orderAffiliateId; // İlk seviye için sipariş vereni kullan

        // Sistemdeki tüm affiliate seviyelerini kontrol et (maksimum tanımlı seviye kadar)
        while ($currentAffiliateId && $level <= $maxLevel) {
            $currentAffiliate = Affiliate::find($currentAffiliateId);

            if (!$currentAffiliate) {
                break;
            }

            // Bu seviye için komisyon kuralını bul
            $commissionRule = null;
            foreach ($commissionRules as $rule) {
                if ($rule->level == $level) {
                    $commissionRule = $rule;
                    break;
                }
            }

            if ($commissionRule && $commissionRule->is_active && $commissionRule->percentage > 0) {
                // Komisyon tutarını hesapla
                $commissionAmount = ($commissionalAmount * $commissionRule->percentage) / 100;

                // Komisyon kaydını oluştur
                $result = AffiliateCommission::create([
                    'affiliate_id' => $currentAffiliate->id,
                    'order_id' => $order->increment_id,
                    'from_affiliate_id' => $currentFromAffiliateId,
                    'level' => $level,
                    'amount' => $commissionAmount,
                    'percentage' => $commissionRule->percentage,
                    'status' => 'pending',
                    'description' => "Sipariş #{$order->id} için {$level}. seviye komisyon (Sepet Tutarı: " . number_format($commissionalAmount, 2) . " €)",
                ]);

                // Affiliate'in toplam komisyon miktarını ve son komisyon tarihini güncelle
                if ($result) {
                    $currentAffiliate->total_commission_earned = $currentAffiliate->total_commission_earned + $commissionAmount;
                    $currentAffiliate->last_commission_at = Carbon::now('Europe/Berlin');
                    $currentAffiliate->save();
                }
            }

            // Bir sonraki seviye için mevcut affiliate from_affiliate olacak
            $currentFromAffiliateId = $currentAffiliateId;
            // Bir üst affiliate'e geç
            $currentAffiliateId = $currentAffiliate->parent_id;
            $level++;
        }
    });
}
}
