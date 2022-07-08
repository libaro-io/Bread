<?php

namespace Libaro\Bread;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Libaro\Bread\Commands\CreateCustomField;
use Libaro\Bread\Commands\CreateCustomFilter;
use Libaro\Bread\Commands\CreateCustomHeader;
use Libaro\Bread\Filters\Filters;
use Libaro\Bread\Services\FilterService;
use Libaro\Bread\Services\SortingService;

class BreadServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerCommands();
        $this->publishes([
            __DIR__.'/Resources' => base_path('Bread/Resources'),
            __DIR__.'/Documentation' => base_path('Bread/Documentation'),
        ], 'bread');
    }

    /**
     * @return void
     */
    public function register(): void
    {
        $this->registerMacros();
    }

    /**
     * Register the commands provided by this package.
     *
     * @return void
     */
    private function registerCommands(): void
    {
        $this->commands([
            CreateCustomField::class,
            CreateCustomHeader::class,
            CreateCustomFilter::class,
        ]);
    }

    private function registerMacros(): void
    {
        Builder::macro('filter', function (Filters $filters) {
            return app(FilterService::class)($this, $filters);
        });
        Builder::macro('sort', function ($defaultColumn = 'id', $defaultDirection = 'desc') {
            return app(SortingService::class)($this, $defaultColumn, $defaultDirection);
        });
    }
}
