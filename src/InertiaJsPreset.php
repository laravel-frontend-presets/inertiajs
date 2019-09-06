<?php

namespace LaravelFrontendPresets\InertiaJsPreset;

use Illuminate\Support\Arr;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Console\Presets\Preset;

class InertiaJsPreset extends Preset
{
    private static $command;

    public static function install($command)
    {
        static::$command = $command;

        static::updatePackages();
        static::installBootstrapDefault();
        static::updateBootstrapping();
        static::updateWelcomePage();
        static::updateGitignore();
        static::scaffoldComponents();
        static::scaffoldRoutes();
        static::removeNodeModules();
    }

    protected static function updatePackageArray(array $packages)
    {
        return array_merge([
            '@babel/plugin-syntax-dynamic-import' => '^7.2.0',
            '@inertiajs/inertia' => '^0.1.0',
            '@inertiajs/inertia-vue' => '^0.1.0',
            'vue' => '^2.5.17',
            'vue-template-compiler' => '^2.6.10',
        ], $packages);
    }

    protected static function updateBootstrapping()
    {
        copy(__DIR__.'/inertiajs-stubs/webpack.mix.js', base_path('webpack.mix.js'));

        copy(__DIR__.'/inertiajs-stubs/resources/js/app.js', resource_path('js/app.js'));

        copy(__DIR__.'/inertiajs-stubs/resources/sass/app.scss', resource_path('sass/app.scss'));
        copy(__DIR__.'/inertiajs-stubs/resources/sass/_nprogress.scss', resource_path('sass/_nprogress.scss'));
    }

    protected static function updateWelcomePage()
    {
        (new Filesystem)->delete(resource_path('views/welcome.blade.php'));

        copy(__DIR__.'/inertiajs-stubs/resources/views/app.blade.php', resource_path('views/app.blade.php'));
    }

    protected static function updateGitignore()
    {
        file_put_contents(
            base_path('.gitignore'),
            file_get_contents(__DIR__.'/inertiajs-stubs/gitignore'),
            FILE_APPEND
        );
    }

    protected static function scaffoldComponents()
    {
        tap(new Filesystem, function ($fs) {
            $fs->deleteDirectory(resource_path('js/components'));

            $fs->copyDirectory(__DIR__.'/inertiajs-stubs/resources/js/Shared', resource_path('js/Shared'));

            $fs->copyDirectory(__DIR__.'/inertiajs-stubs/resources/js/Pages', resource_path('js/Pages'));
        });
    }

    protected static function scaffoldRoutes()
    {
        copy(__DIR__.'/inertiajs-stubs/routes/web.php', base_path('routes/web.php'));
    }

    protected static function installBootstrapDefault()
    {
        if (! file_exists(base_path('composer.json'))) {
            return;
        }

        tap(new Process('composer require --dev laravel/ui=^1.0', base_path()), function ($process) {
            $process->run();

            Artisan::call('preset bootstrap', [], static::$command->getOutput());
        });

        tap(new Process('composer remove --dev laravel/ui', base_path()), function ($process) {
            $process->run();
        });
    }
}
