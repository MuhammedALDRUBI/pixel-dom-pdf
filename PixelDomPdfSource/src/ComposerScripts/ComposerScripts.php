<?php

namespace PixelDomPdf\ComposerScripts;


use Illuminate\Support\Facades\Artisan;

class ComposerScripts
{

    public static function installDefaultFont()
    {  
        $vendorFolderPath = __DIR__ . "../../../../..";
        $autoloaderPath = $vendorFolderPath . "/autoload.php";

        $laravelPrjectBasePath = $vendorFolderPath . "/..";
        $laravelAppPath = $laravelPrjectBasePath . "/bootstrap/app.php";

        if (file_exists($autoloaderPath) && file_exists($laravelAppPath))
        {

            require $autoloaderPath;
            $app = require_once $laravelAppPath;

            $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
            $kernel->bootstrap();

            Artisan::call('pixel-dom-pdf:register-fonts');
            echo Artisan::output();  

        }else {
            echo "Laravel bootstrap files not found. Make sure this script runs in a Laravel environment.\n";
        }
    }

}