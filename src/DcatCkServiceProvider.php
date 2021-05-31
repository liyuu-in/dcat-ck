<?php

namespace Liyuu\DcatCK;

use CKSource\CKFinder\CKFinder;
use Dcat\Admin\Form;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\HttpKernel\Kernel;
use Liyuu\DcatCK\Http\Middleware\CKFinderMiddleware;

class DcatCkServiceProvider extends ServiceProvider
{

    protected $middleware = [
        'middle' => [
            CKFinderMiddleware::class
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/dcat-ck'),
                __DIR__ . '/config.php' => config_path('ckfinder.php')
            ], 'dcat-ck');
        }

        $extension = DcatCk::make();

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, DcatCk::NAME);
        }

        //if ($lang = $extension->lang()) {
        //    $this->loadTranslationsFrom($lang, DcatCk::NAME);
        //}

        //if ($migrations = $extension->migrations()) {
        //    $this->loadMigrationsFrom($migrations);
        //}s


        $this->app->booted(function () use ($extension) {
            Form::extend('ckeditor', CKEditor::class);
            Form::extend('ckuploader', CKUploader::class);
            $extension->routes(__DIR__.'/../routes/web.php');
        });

    }

    public function register()
    {

        $this->app->bind('CKConnector', function () {

            $ckfinder = new CKFinder(config('ckfinder', []));

            if (Kernel::MAJOR_VERSION === 4) {
                $this->setupForV4Kernel($ckfinder);
            }

            return $ckfinder;
        });
    }

    protected function setupForV4Kernel($ckfinder)
    {
        $ckfinder['resolver'] = function () use ($ckfinder) {
            $commandResolver = new \Liyuu\DcatCK\Polyfill\CommandResolver($ckfinder);
            $commandResolver->setCommandsNamespace(CKFinder::COMMANDS_NAMESPACE);
            $commandResolver->setPluginsNamespace(CKFinder::PLUGINS_NAMESPACE);

            return $commandResolver;
        };

        $ckfinder['kernel'] = function () use ($ckfinder) {
            return new HttpKernel(
                $ckfinder['dispatcher'],
                $ckfinder['resolver'],
                $ckfinder['request_stack'],
                $ckfinder['resolver']
            );
        };
    }

}
