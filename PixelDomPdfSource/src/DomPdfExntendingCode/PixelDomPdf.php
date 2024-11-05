<?php

namespace PixelDomPdf\DomPdfExntendingCode;

use Dompdf\Dompdf;
use PixelDomPdf\Interfaces\PixelPdfNeedsProvider;

class PixelDomPdf extends Dompdf implements PixelPdfNeedsProvider
{

    public function loadView(View $view)
    {
        $html = $view->render();
        $this->loadHtml($html);
    }

    public function stream($filename = "document.pdf", $options = [])
    {
        $this->render();
        parent::stream($filename , $options);
    }

    public function output($options = [])
    {
        $this->render();
        return parent::output($options);
    }
    
}