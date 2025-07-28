<?php

namespace PixelDomPdf\DomPdfExntendingCode;

use Dompdf\Dompdf;
use PixelDomPdf\Interfaces\PixelPdfNeedsProvider;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function stream($filename = "document.pdf", $options = [])
    {
        $this->render();
        parent::stream($filename , $options);
    }

    /**
     * another functinality of streaming for laravel , we kept return type and name convention for our packages
     */
    public function downloadDataFile($filename = "document.pdf", $options = []) : StreamedResponse
    {
        $content = $this->output($options);
        
        return new StreamedResponse(
                    function() use ($content)
                    {
                        echo $content;
                    },
                    200,
                    [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => ($options['Attachment'] ?? true ? 'attachment' : 'inline') . '; filename="' . $filename . '"',
                    ]
                );
    }

    /**
     * Returns the PDF as a string.
     */
    public function output($options = [])
    {
        $this->render();
        parent::output($options);
    }

    //an alias method for return type and name convention
    public function exportDataFile($options = []) : string|null
    {
        return $this->output($options);
    }

    public function render()
    {
        if($this->DoesItNeedRendering())
        {
            parent::render();
            
            $this->hasRendered();
        }
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