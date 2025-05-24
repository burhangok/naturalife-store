<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    public function index()
    {
        return view('affiliatemodule.admin.dashboard', );
    }
    public function affiliateDashboard()
    {
        return view('affiliatemodule.shop.affiliate_dashboard', );
    }


}
