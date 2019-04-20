<?php

namespace LaravelFrontendPresets\InertiaJsPreset;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\Presets\Preset;
use Illuminate\Support\Arr;

class InertiaJsPreset extends Preset
{
    public static function install()
    {
        static::updatePackages();
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
            'inertia' => 'github:inertiajs/inertia',
            'inertia-vue' => 'inertiajs/inertia-vue',
            'vue-template-compiler' => '^2.6.10',
        ], $packages);
    }

    protected static function updateBootstrapping()
    {
        copy(__DIR__.'/inertiajs-stubs/.babelrc', base_path('.babelrc'));

        copy(__DIR__.'/inertiajs-stubs/webpack.mix.js', base_path('webpack.mix.js'));

        copy(__DIR__.'/inertiajs-stubs/resources/js/app.js', resource_path('js/app.js'));
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
        (new Filesystem)->copyDirectory(__DIR__.'/inertiajs-stubs/resources/js/Shared', resource_path('js'));

        (new Filesystem)->copyDirectory(__DIR__.'/inertiajs-stubs/resources/js/Pages', resource_path('js'));
    }

    protected static function scaffoldRoutes()
    {
        copy(__DIR__.'/inertiajs-stubs/routes/web.php', base_path('routes/web.php'));
    }
}
