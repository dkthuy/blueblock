<?php

namespace Mrthat1996\KleeBugsReport\Providers;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot(): void
    {
        $this->setUpConfig();
    }

    private function setUpConfig()
    {
        $this->publishes([
            __DIR__ . '/../../config/klee_bugs_report.php' => config_path('klee_bugs_report.php')
        ]);
    }
}