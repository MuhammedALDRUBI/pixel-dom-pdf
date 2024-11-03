<?php

namespace PixelDomPdf\ServiceProviders;

use Dompdf\Options;
use Illuminate\Support\ServiceProvider;
use PixelDomPdf\PixelDomPdf;

class PixelDomPdfServiceProvider extends ServiceProvider
{
 
    /**
     * Register the service provider.
     *
     * @throws \Exception
     * @return void
     */
    public function register(): void
    {
        $this->mergePackageConfig();

        $this->registerDomPdfOptions();

        $this->registerPixelDomPdf();
    }

    public function boot()
    {   
        $this->allowConfigPublishing();
    }

    protected function allowConfigPublishing() : void
    {
        $this->publishes(
            [
                $this->getPackageConfiAbsolutePath() => config_path("pixel-dompdf") 
            ] ,
            'pixel-dompdf-config'
        );
    }

    protected function getPackageConfiAbsolutePath() : string
    {
        return __DIR__ . '/../../../Config/pixel-dompdf.php';
    }

    protected function mergePackageConfig() : void
    {
        $this->mergeConfigFrom($this->getPackageConfiAbsolutePath(), 'pixel-dompdf');
    }

    protected function registerDomPdfOptions() : void
    {
        $this->app->bind('dompdf.options', function ($app) 
        {         
            $options = $app['config']->get('pixel-dompdf.options');
            return new Options($options);
        });
 
    }

    protected function getDomPdfRealPath($app) : string
    {
        $path = realpath($app['config']->get('pixel-dompdf.public_path') ?: base_path('public'));
        if ($path === false) {
            throw new \RuntimeException('Cannot resolve public path');
        }
        return $path;
    }

    protected function registerPixelDomPdf(): void
    {
        $this->app->bind('dompdf', function ($app) {

            $options = $app->make('dompdf.options');

            $pixelDompdf = new PixelDomPdf($options);
            $path = $this->getDomPdfRealPath($app);
            $pixelDompdf->setBasePath($path);

            return $pixelDompdf;
        });
    }

}