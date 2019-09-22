<?php

namespace LaravelFrontendPresets\InertiaJsPreset;

use Illuminate\Foundation\Console\PresetCommand;
use Illuminate\Support\ServiceProvider;

class InertiaJsPresetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        PresetCommand::macro('inertiajs', function ($command) {
            InertiaJsPreset::install();

            $command->info('Inertia.js scaffolding installed successfully.');
            $command->info('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });
    }
}
