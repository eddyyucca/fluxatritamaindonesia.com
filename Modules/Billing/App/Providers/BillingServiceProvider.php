<?php

namespace Modules\Billing\App\Providers;

use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'billing');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }
}
