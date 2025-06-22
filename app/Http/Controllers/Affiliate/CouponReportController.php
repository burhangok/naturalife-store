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

}


