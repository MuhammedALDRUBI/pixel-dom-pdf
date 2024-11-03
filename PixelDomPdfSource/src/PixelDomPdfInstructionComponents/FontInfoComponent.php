<?php

namespace PixelDomPdf\PixelDomPdfInstructionComponents;

class FontInfoComponent
{
    
    protected string $fontFamily ;
    protected string | int $fontWeight ;
    protected string $fontStyle ;
    protected string $fontFileAbsolutePath;

    public function __construct(string $fontFamily , string | int $fontWeight , string $fontFileAbsolutePath , string $fontStyle = "normal")
    {
        $this->setFontFamily($fontFamily)->setFontWeight($fontWeight)->setFontFileAbsolutePath($fontFileAbsolutePath)->setFontStyle($fontStyle);
    }
    public static function create(string $fontFamily , string | int $fontWeight , string $fontFileAbsolutePath , string $fontStyle = "normal") : self
    {
        return new static($fontFamily , $fontWeight  , $fontFileAbsolutePath, $fontStyle);
    }

    public function setFontFamily(string $fontFamily) : self
    {
        $this->fontFamily = $fontFamily;
        return $this;
    }
    
    public function setFontWeight(string $fontWeight) : self
    {
        $this->fontWeight = $fontWeight;
        return $this;
    }
    
    public function setFontStyle(string $fontStyle) : self
    {
        $this->fontStyle = $fontStyle;
        return $this;
    }
    
    public function setFontFileAbsolutePath(string $fontFileAbsolutePath) : self
    {
        $this->fontFileAbsolutePath = $fontFileAbsolutePath;
        return $this;
    }
    public function getFontFamily() : string
    {
        return $this->fontFamily;
    }
    public function getFontWeight() : string|int
    {
        return $this->fontWeight;
    }
    public function getFontStyle() : string
    {
        return $this->fontStyle;
    }
    public function getFontFileAbsolutePath() : string
    {
        return $this->fontFileAbsolutePath;
    }
}