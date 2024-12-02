<?php

namespace PixelDomPdf\ComposerScripts;


use Illuminate\Support\Facades\Artisan;

class ComposerScripts
{

    public static function installDefaultFont()
    {  
        Artisan::call('pixel-dom-pdf:register-fonts');
        echo Artisan::output();  
    }

}