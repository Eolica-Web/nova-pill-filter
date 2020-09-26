<?php

namespace Eolica\NovaPillFilter;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

final class FilterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Nova::serving(function (ServingNova $event) {
            Nova::script('pill-filter', __DIR__ . '/../dist/js/filter.js');
        });
    }

    public function register()
    {
        $this->commands([
            Console\PillFilterCommand::class,
            Console\StubPublishCommand::class,
        ]);
    }
}
