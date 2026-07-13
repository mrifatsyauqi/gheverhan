<?php

namespace App\Providers;

use App\Services\CartService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(RepositoryServiceProvider::class);
    }

    public function boot(): void
    {
        // Share cart count with all views
        View::composer('layouts.partials.navbar', function ($view) {
            try {
                $cartCount = app(CartService::class)->getCartCount();
            } catch (\Exception) {
                $cartCount = 0;
            }
            $view->with('cartCount', $cartCount);
        });

        View::composer('layouts.partials.mobile-nav', function ($view) {
            try {
                $cartCount = app(CartService::class)->getCartCount();
            } catch (\Exception) {
                $cartCount = 0;
            }
            $view->with('cartCount', $cartCount);
        });
    }
}
