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

class AffiliateCommissionShopController extends Controller
{
    /**
     * Komisyon listesini görüntüle
     */
    public function showCommissions(Affiliate $affiliate)
    {
        $commissions = AffiliateCommission::with(['affiliate', 'order', 'fromAffiliate'])
            ->where('affiliate_id', $affiliate->id)
            ->latest()
            ->groupBy('order_id')->get();

        return view('affiliatemodule.shop.affiliate_commissions', compact('commissions','affiliate'));
    }

}
