<?php

namespace ResumeCraft;

use Mpdf\MpdfException;
use ResumeCraft\Services\PDFEngine;
use ResumeCraft\Services\TemplateEngine;

/**
 * Class ResumePDFGenerator
 * Generates a PDF resume from JSON data using Twig and mPDF.
 */
class ResumePDFGenerator
{
    private TemplateEngine $templateEngine;

    /**
     * @param TemplateEngine $templateEngine
     */
    public function __construct(TemplateEngine $templateEngine)
    {
        // Initialize Twig and PDF Engine
        $this->templateEngine = $templateEngine;
    }

    /**
     * Generates a PDF resume.
     *
     * @param string $dataFile Path to the JSON data file.
     * @throws MpdfException
     */
    public function generatePDF(string $dataFile): void
    {
        $resumeData = json_decode(file_get_contents($dataFile), true);

        $htmlContent = $this->templateEngine->getHTML($resumeData);

        $PDFEngine = new PDFEngine();
        $PDFEngine($this->getPDFMeta($resumeData), $htmlContent);

    }

    /**
     * @param $resumeData
     * @return array
     */
    private function getPDFMeta($resumeData): array
    {
        return [
            'pdfTitle' => $resumeData['config']['pdfTitle'],
            'pdfAuthor' => $resumeData['config']['pdfAuthor'],
            'pdfCreator' => $resumeData['config']['pdfCreator'],
            'pdfSubject' => $resumeData['config']['pdfSubject'],
            'pdfKeywords' => $resumeData['config']['pdfKeywords'],
        ];
    }
}
