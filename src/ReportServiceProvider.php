<?php

namespace Aungmyat\Report;

use Illuminate\Support\ServiceProvider;

class ReportServiceProvider extends ServiceProvider{

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/views','report');
    }

    public function register()
    {

    }

}