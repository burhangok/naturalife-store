<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


use Illuminate\Support\Facades\Artisan;

class HelperController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function runMigrations()
    {

        $result = Artisan::call('migrate', ["--force" => true]);
        return $result;
    }

    public function clearCache()
    {

        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize');
        Artisan::call('clear-compiled');

        // Flash message göndermeyi deneyelim
        session()->flash('success', 'Cache temizleme başarılı!');

        return back();
    }

}
