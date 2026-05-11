<?php

namespace App\Providers;

use App\Models\CompanyProfile;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            View::share('companyProfile', CompanyProfile::first());
        } catch (QueryException) {
            View::share('companyProfile', null);
        }
    }
}
