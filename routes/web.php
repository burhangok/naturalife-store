<?php


use App\Http\Controllers\Affiliate\AffiliateCommissionShopController;
use App\Http\Controllers\Affiliate\AffiliateController;
use App\Http\Controllers\Affiliate\AffiliateShopController;
use App\Http\Controllers\Affiliate\CommissionRuleController;
use App\Http\Controllers\Affiliate\AffiliateCommissionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HelperController;

// Link tracking
Route::get('/ref/{code}', [AffiliateController::class, 'redirect']);
Route::post('/affiliate/conversion/{conversionId?}', [AffiliateController::class, 'markConversion']);



//musteri panel rotalari -- customer panel routes
Route::prefix('customer')->group(function () {
    Route::group(['middleware' => ['customer']], function () {
        Route::prefix('affiliatemodule')->group(function () {

            Route::controller(AffiliateShopController::class)->group(function () {
                Route::post('', 'store')->name('shop.customers.affiliate.store');

                      Route::get('/profile/{affiliate}', 'profile')->name('shop.customers.affiliatemodule.profile');
                      Route::get('/myaffiliates', 'myaffiliates')->name('shop.customers.affiliatemodule.myaffiliates');

            });

            Route::get('/commissions/{affiliate}', [AffiliateCommissionShopController::class, 'showcommissions'])->name('shop.customers.affiliatemodule.commissions');




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

        });




    });
});
