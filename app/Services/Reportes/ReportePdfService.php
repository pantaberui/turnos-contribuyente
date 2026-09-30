<?php

namespace App\Services\Reportes;
use Spatie\Browsershot\Browsershot;

class ReportePdfService
{
   public function generarDesdeHtml(
        string $html,
        ?string $headerHtml = null,
        ?string $footerHtml = null
    ): string {
        $browsershot = Browsershot::html($html)
            ->format('Letter')
            ->margins(14, 5, 10, 5)
            ->showBackground();

        if ($headerHtml || $footerHtml) {
            $browsershot->showBrowserHeaderAndFooter();

            if ($headerHtml) {
                $browsershot->headerHtml($headerHtml);
            }

            if ($footerHtml) {
                $browsershot->footerHtml($footerHtml);
            }
        }

        return $browsershot->pdf();
    }
}