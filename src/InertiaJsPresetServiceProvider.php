<?php

namespace LaravelFrontendPresets\InertiaJsPreset;

use Illuminate\Support\ServiceProvider;
use Laravel\Ui\UiCommand;

class InertiaJsPresetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        UiCommand::macro('inertiajs', function (UiCommand $command) {
            InertiaJsPreset::install();

            $command->info('Inertia.js scaffolding installed successfully.');
            $command->info('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });
    }
}
