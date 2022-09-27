<?php

namespace App\Providers;
use Cart;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
// use App\Models\User;
// use App\Observers\UserObserver;
// use App\Models\vendor;
// use App\Observers\VendorObserver;
// use App\Models\Product;
// use App\Observers\ProductObserver;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Forcing URL to redirect HTTPS in LIVE and Default value should be false for local server .env file
        if(env('FORCE_HTTPS',false)) {
            url()->forceScheme('https');
        }

        //for pagination
        Paginator::useBootstrap();

        //observer
        // User::observe(UserObserver::class);
        // Vendor::observe(VendorObserver::class);
        // Product::observe(ProductObserver::class);
    }
}
