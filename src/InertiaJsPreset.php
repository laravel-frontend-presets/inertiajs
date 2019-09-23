<?php

namespace LaravelFrontendPresets\InertiaJsPreset;

use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\Presets\Preset;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class InertiaJsPreset extends Preset
{
    public static function install()
    {
        static::updatePackages();
        static::updateBootstrapping();
        static::updateComposer(false);
        static::publishInertiaServiceProvider();
        static::registerInertiaServiceProvider();
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

    protected static function updateComposerArray(array $packages)
    {
        return array_merge([
            'inertiajs/inertia-laravel' => '^0.1',
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

    protected static function updateComposer($dev = true)
    {
        if (! file_exists(base_path('composer.json'))) {
            return;
        }

        $configurationKey = $dev ? 'require-dev' : 'require';

        $packages = json_decode(file_get_contents(base_path('composer.json')), true);

        $packages[$configurationKey] = static::updateComposerArray(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('composer.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    public static function publishInertiaServiceProvider()
    {
        copy(
            __DIR__.'/inertiajs-stubs/providers/InertiaJsServiceProvider.stub',
            app_path('Providers/InertiaJsServiceProvider.php')
        );
    }

    public static function registerInertiaServiceProvider()
    {
        $namespace = Str::replaceLast('\\', '', Container::getInstance()->getNamespace());

        $appConfig = file_get_contents(config_path('app.php'));

        if (Str::contains($appConfig, $namespace.'\\Providers\\InertiaJsServiceProvider::class')) {
            return;
        }

        $lineEndingCount = [
            "\r\n" => substr_count($appConfig, "\r\n"),
            "\r" => substr_count($appConfig, "\r"),
            "\n" => substr_count($appConfig, "\n"),
        ];

        $eol = array_keys($lineEndingCount, max($lineEndingCount))[0];

        file_put_contents(config_path('app.php'), str_replace(
            "{$namespace}\\Providers\\RouteServiceProvider::class,".$eol,
            "{$namespace}\\Providers\\RouteServiceProvider::class,".$eol."        {$namespace}\Providers\InertiaJsServiceProvider::class,".$eol,
            $appConfig
        ));

        file_put_contents(app_path('Providers/InertiaJsServiceProvider.php'), str_replace(
            "namespace App\Providers;",
            "namespace {$namespace}\Providers;",
            file_get_contents(app_path('Providers/InertiaJsServiceProvider.php'))
        ));
    }
}
