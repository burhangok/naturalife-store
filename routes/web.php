<?php


use App\Http\Controllers\Affiliate\AffiliatePaymentController;
use App\Http\Controllers\Affiliate\AffiliateCommissionShopController;
use App\Http\Controllers\Affiliate\AffiliateController;
use App\Http\Controllers\Affiliate\AffiliateShopController;
use App\Http\Controllers\Affiliate\CommissionRuleController;
use App\Http\Controllers\Affiliate\AffiliateCommissionController;
use App\Http\Controllers\Affiliate\CouponReportController;
use App\Http\Controllers\AffiliatePaymentMethodController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HelperController;
use Webkul\Shop\Http\Controllers\HomeController;

// Link tracking
Route::get('/ref/{code}', [HomeController::class, 'registerAffiliateWithReference'])->name('affiliate.registerwithreference');
Route::post('/affiliate/conversion/{conversionId?}', [AffiliateController::class, 'markConversion']);

// routes/web.php
Route::get('/promo/{code}', [HomeController::class, 'applyCoupon']);
Route::get('/coupon/{code}', [HomeController::class, 'applyCoupon']);

//musteri panel rotalari -- customer panel routes
Route::prefix('customer')->group(function () {
    Route::group(['middleware' => ['customer']], function () {
        Route::prefix('affiliatemodule')->group(function () {

            Route::controller(AffiliateShopController::class)->group(function () {
                Route::post('', 'store')->name('shop.customers.affiliatemodule.store');

                      Route::get('/profile/{affiliate}', 'profile')->name('shop.customers.affiliatemodule.profile');
                Route::get('/payments', 'payments')->name('shop.customers.affiliatemodule.payments');
                Route::get('/myaffiliates', 'myaffiliates')->name('shop.customers.affiliatemodule.myaffiliates');


                Route::get('/coupon-details/{id}', [CouponReportController::class, 'getCouponDetails']);
                Route::get('/coupon-orders/{id}', [CouponReportController::class, 'getCouponOrders']);

            });

            Route::get('/commissions/{affiliate}', [AffiliateCommissionShopController::class, 'showcommissions'])->name('shop.customers.affiliatemodule.commissions');
            Route::post('/paymentmethod/{affiliate}', [AffiliatePaymentMethodController::class, 'store'])->name('shop.customers.affiliatemodule.paymentmethod');
            Route::resource('affiliate-payments', AffiliatePaymentController::class);
            Route::get('/coupons/{affiliate}', [CouponReportController::class, 'couponsByAffiliate'])->name('shop.customers.affiliatemodule.coupons');




        });
    });
});

// Admin panel routes
Route::group(['middleware' => ['web', 'admin'], 'prefix' => config('app.admin_url')], function () {
    Route::get('/clear-cache', [HelperController::class, 'clearCache'])->name('admin.clear.cache');
    Route::get('/run-migrations', [HelperController::class, 'runMigrations']);



    // Affiliate module with custom admin panel
    Route::group(['prefix' => 'affiliatemodule'], function () {
        // Dashboard route
        Route::get('/admin', [DashboardController::class, 'index'])
     ->name('admin.affiliatemodule.admin.dashboard');

        // Admin routes
        Route::group(['prefix' => 'admin'], function () {
  // Affiliates management
        Route::group(['prefix' => 'affiliates'], function () {
            Route::get('/', [AffiliateController::class, 'index'])->defaults('_config', [
                'view' => 'affiliatemodule::admin.affiliates.index',
            ])->name('admin.affiliatemodule.admin.affiliates.index');

            Route::get('/create', [AffiliateController::class, 'create'])->defaults('_config', [
                'view' => 'affiliatemodule::admin.affiliates.create',
            ])->name('admin.affiliatemodule.admin.affiliates.create');

            Route::post('/', [AffiliateController::class, 'store'])->defaults('_config', [
                'redirect' => 'admin.affiliatemodule.affiliates.index',
            ])->name('admin.affiliatemodule.admin.affiliates.store');

            Route::get('/{id}/edit', [AffiliateController::class, 'edit'])->defaults('_config', [
                'view' => 'affiliatemodule::admin.affiliates.edit',
            ])->name('admin.affiliatemodule.admin.affiliates.edit');


                Route::get('/coupon-details/{id}', [CouponReportController::class, 'getCouponDetails']);
                   Route::get('/coupon-orders/{id}', [CouponReportController::class, 'getCouponOrders']);
                               Route::put('/{id}', [AffiliateController::class, 'update'])->defaults('_config', [
                'redirect' => 'admin.affiliatemodule.affiliates.index',
            ])->name('admin.affiliatemodule.admin.affiliates.update');

            Route::delete('/{id}', [AffiliateController::class, 'destroy'])->name('admin.affiliatemodule.admin.affiliates.delete');
        });
            // Commission rules management
            Route::group(['prefix' => 'commissionrules'], function () {
                Route::get('/', [CommissionRuleController::class, 'index'])->name('admin.affiliatemodule.admin.commissionrules.index');
                Route::get('/create', [CommissionRuleController::class, 'create'])->name('admin.affiliatemodule.admin.commissionrules.create');
                Route::post('/', [CommissionRuleController::class, 'store'])->name('admin.affiliatemodule.admin.commissionrules.store');
                Route::get('/{commissionRule}/edit', [CommissionRuleController::class, 'edit'])->name('admin.affiliatemodule.admin.commissionrules.edit');
                Route::put('/{commissionRule}', [CommissionRuleController::class, 'update'])->name('admin.affiliatemodule.admin.commissionrules.update');
                Route::delete('/{commissionRule}', [CommissionRuleController::class, 'destroy'])->name('admin.affiliatemodule.admin.commissionrules.destroy');
            });

            // Commissions management
            Route::group(['prefix' => 'commissions'], function () {
                Route::get('/', [AffiliateCommissionController::class, 'index'])->name('admin.affiliatemodule.admin.commissions.index');
                Route::get('/{commission}', [AffiliateCommissionController::class, 'edit'])->name('admin.affiliatemodule.admin.commissions.edit');
                Route::put('/{commission}', [AffiliateCommissionController::class, 'update'])->name('admin.affiliatemodule.admin.commissions.update');
            });

            // couponreports management
            Route::group(['prefix' => 'couponreports'], function () {
                Route::get('/', [CouponReportController::class, 'index'])->name('admin.affiliatemodule.admin.couponreports.index');
                Route::get('/{couponreport}', [CouponReportController::class, 'edit'])->name('admin.affiliatemodule.admin.couponreports.edit');
                     });

             // affiliatepayments management
             Route::group(['prefix' => 'affiliatepayments'], function () {
                Route::get('/', [AffiliatePaymentController::class, 'index'])->name('admin.affiliatemodule.admin.affiliatepayments.index');
                Route::post('/', [AffiliatePaymentController::class, 'store'])->name('admin.affiliatemodule.admin.affiliatepayments.store');
                Route::get('/{payment}', [AffiliatePaymentController::class, 'edit'])->name('admin.affiliatemodule.admin.affiliatepayments.edit');
                Route::put('/{payment}', [AffiliatePaymentController::class, 'update'])->name('admin.affiliatemodule.admin.affiliatepayments.update');
                Route::delete('/{payment}', [AffiliatePaymentController::class, 'destroy'])->name('admin.affiliatemodule.admin.affiliatepayments.destroy');
            });
                   });






    });
});
