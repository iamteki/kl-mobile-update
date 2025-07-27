<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\EventType;
use Illuminate\Support\Facades\Schema;
use App\Models\Settings;

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
          // Share event types with the contact component
        View::composer('components.contact', function ($view) {
            $eventTypes = EventType::where('status', true)
                ->orderBy('order')
                ->orderBy('name')
                ->get();
            
            $view->with('eventTypes', $eventTypes);
        });
        
        // Or share with all views that might need it
        View::composer(['components.contact', 'home.index', 'layouts.*'], function ($view) {
            $eventTypes = EventType::where('status', true)
                ->orderBy('order')
                ->orderBy('name')
                ->get();
            
            $view->with('eventTypes', $eventTypes);
        });

         // Share settings data with footer component and all layouts
        View::composer(['components.footer', 'layouts.*'], function ($view) {
            $settings = Settings::current();
            $view->with('settings', $settings);
        });

        Schema::defaultStringLength(191);
    }
}
