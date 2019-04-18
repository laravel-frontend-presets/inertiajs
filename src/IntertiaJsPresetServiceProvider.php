<?php

namespace LaravelFrontendPresets\InertiaJsPreset;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Console\PresetCommand;

class IntertiaJsPresetServiceProvider extends ServiceProvider
{
    public function boot()
    {
        PresetCommand::macro('inertiajs', function ($command) {
            IntertiaJsPreset::install();

            $command->info('Inertia.js scaffolding installed successfully.');
            $command->info('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
        });
    }
}
