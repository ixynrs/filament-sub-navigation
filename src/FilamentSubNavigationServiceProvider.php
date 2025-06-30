<?php

namespace HayderHatem\FilamentSubNavigation;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentSubNavigationServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-sub-navigation';

    public function configurePackage(Package $package): void
    {
        $package->name(static::$name);
    }

    public function packageBooted(): void
    {
        // Register assets for sub-navigation (always load to ensure availability)
        FilamentAsset::register([
            Css::make('filament-sub-navigation-styles', __DIR__ . '/../resources/dist/filament-sub-navigation.css'),
            Js::make('filament-sub-navigation-script', __DIR__ . '/../resources/dist/filament-sub-navigation.js'),
        ], package: 'hayderhatem/filament-sub-navigation');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'filament-sub-navigation');

        // Register Blade components
        \Illuminate\Support\Facades\Blade::component('filament-sub-navigation::components.alpine-sub-navigation', 'sub-navigation');
    }

    public function boot(): void
    {
        parent::boot();

        // Publish assets to ensure they're available
        $this->publishes([
            __DIR__ . '/../resources/dist' => public_path('js/hayderhatem/filament-sub-navigation'),
        ], 'filament-sub-navigation-assets');
    }
}
