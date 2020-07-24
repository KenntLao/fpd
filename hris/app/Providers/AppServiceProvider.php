<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Illuminate\Support\Facades\Schema;
use App\hris_employee;

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
    public function boot(Dispatcher $events)
    {
        Schema::defaultStringLength(191);
        
        view()->composer('adminlte::partials.navbar.navbar', function($view){
            if($_SESSION['sys_account_mode'] == 'employee'){
                $emp = hris_employee::find($_SESSION['sys_id']);
            }else {
                $emp = '';
            }
            $view->with('emp', $emp);
        });
    }
}
