<?php

namespace PixelDomPdf\Interfaces;

use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface PixelPdfNeedsProvider
{

    public function useView(View $view) :PixelPdfNeedsProvider;

    /**
     * Loads an HTML string
     * Parse errors are stored in the global array _dompdf_warnings.
     *
     * @param string $str HTML text to load
     * @param string $encoding Encoding of $str
     */
    public function useHtml($str, $encoding = null)  :PixelPdfNeedsProvider;


    
    /**
     * Returns the PDF as a string.
     *
     * The options parameter controls the output. Accepted options are:
     *
     * 'compress' = > 1 or 0 - apply content stream compression, this is
     *    on (1) by default
     *
     * @param array $options options (see above)
     *
     * @return string|null
     */
    public function exportDataFile($options = []) : string|null;

     /**
     * Streams the PDF to the client.
     *
     * The file will open a download dialog by default. The options
     * parameter controls the output. Accepted options (array keys) are:
     *
     * 'compress' = > 1 (=default) or 0:
     *   Apply content stream compression
     *
     * 'Attachment' => 1 (=default) or 0:
     *   Set the 'Content-Disposition:' HTTP header to 'attachment'
     *   (thereby causing the browser to open a download dialog)
     *
     * @param string $filename the name of the streamed file
     * @param array $options header options (see above)
     */
    public function downloadDataFile($filename = "document.pdf", $options = []) : StreamedResponse;
}