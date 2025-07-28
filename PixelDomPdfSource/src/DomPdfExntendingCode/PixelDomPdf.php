<?php

namespace PixelDomPdf\DomPdfExntendingCode;

use Dompdf\Dompdf;
use PixelDomPdf\Interfaces\PixelPdfNeedsProvider;
use Illuminate\Contracts\View\View;

class PixelDomPdf extends Dompdf implements PixelPdfNeedsProvider
{
    const PixelDefaultFontFolder = __DIR__ . "/../PixelDefaultFonts";
    
    protected bool $needsRendering = true;

    protected function hasRendered() : void
    {
        $this->needsRendering = false;
    }

    protected function needsRendering() : void
    {
        $this->needsRendering = true;
    }

    protected function DoesItNeedRendering() : bool
    {
        return $this->needsRendering;
    }
    
    public function useView(View $view) :PixelPdfNeedsProvider
    {
        $html = $view->render();

        return $this->useHtml($html);
    }

    public function useHtml($str, $encoding = null)  :PixelPdfNeedsProvider
    {
        $this->loadHtml($str, $encoding );

        return $this;
    }

    public function loadHtml($str, $encoding = null)
    {
        parent::loadHtml($str , $encoding);
        
        $this->needsRendering();
    }

    protected function renderHTMLOnNeed() : void
    {
        if($this->DoesItNeedRendering())
        {
            $this->render();  
        }
    }

    public function stream($filename = "document.pdf", $options = [])
    {
        $this->renderHTMLOnNeed();
        parent::stream($filename , $options);
    }

    //an alias method for return type and name convention
    public function downloadDataFile($filename = "document.pdf", $options = []) : void
    {
        $this->stream($filename , $options);
    }

    public function output($options = [])
    {
        $this->renderHTMLOnNeed();
        parent::output($options);
    }

    //an alias method for return type and name convention
    public function exportDataFile($options = []) : string|null
    {
        return $this->output($options);
    }

    public function render()
    {
        parent::render();
        
        $this->hasRendered();
    }
    
     /**
     * an alias method for return type and name convention
     *
     * Renders the HTML to PDF
     */
    public function renderLoadedHTML() : void
    {
        $this->render();
    }
     
}