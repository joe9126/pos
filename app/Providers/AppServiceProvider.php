<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Models\Currency; 
use Yajra\DataTables\Html\Builder;

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
       $curr ="";
        View::composer('*', function ($view) {
            $curr =  $currency = Currency::where('status',true)->value('code');
           $view->with('currency', $currency);
        }); 

        // Bind the variable to the service container
        $curr = Currency::where('status',true)->value('code');
        $this->app->instance('currency', $curr);

        Paginator::useBootstrap();

        Builder::useVite();
    }
}
