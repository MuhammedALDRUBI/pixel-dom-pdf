<?php

namespace PixelDomPdf\DomPdfExntendingCode;

use Dompdf\Dompdf;

class PixelDomPdf extends Dompdf
{

     /**
     * Class constructor
     *
     * @param Options|array|null $options
     */
    public function __construct($options = null)
    {
        parent::__construct($options);
        //$this->setPixelDefaultFont();
    }

    public function getPixelDefaultFontName() : ?string
    {
        return config("pixel-dompdf.pixel-default-font-name");
    }
    
    public function getPixelDefaultFontVariantPaths() : array
    {
        return config("pixel-dompdf.pixel-default-font-variant-paths" )  ;
    }

    protected function sanitizeFontVariantPaths(array $paths) : array
    {
        return array_map(function($path){
                    // we need the path until the font name ... it will be append with ufm exntension by OpenFont dompdf's method
                    return rtrim($path , ".ttf"); 

                } , $paths);
    }
    protected function setPixelDefaultFont() : void
    {
        $defaultFont = $this->getPixelDefaultFontName();
        $defaulltFontVariantPaths = $this->getPixelDefaultFontVariantPaths();

        if(
            $defaultFont 
            &&
            !in_array(  $defaultFont , $this->getFontMetrics()->getFontFamilies())
            &&
            (is_array($defaulltFontVariantPaths) && !empty($defaulltFontVariantPaths))
          )
        { 
            $defaulltFontVariantPaths = $this->sanitizeFontVariantPaths($defaulltFontVariantPaths);
            $this->getFontMetrics()->setFontFamily($defaultFont, $defaulltFontVariantPaths);
        }
    }
}