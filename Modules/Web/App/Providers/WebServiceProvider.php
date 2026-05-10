<?php

namespace Modules\Web\App\Providers;

use Illuminate\Support\ServiceProvider;

class WebServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'web');
    }
}
