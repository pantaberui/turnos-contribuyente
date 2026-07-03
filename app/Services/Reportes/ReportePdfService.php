<?php

namespace App\Services\Reportes;
use Spatie\Browsershot\Browsershot;

class ReportePdfService
{
    public function generarDesdeHtml(string $html): string
    {
        return Browsershot::html($html)
            ->format('Letter')
            ->margins(5, 5, 5, 5)
            ->showBackground()
            ->pdf();
    }
}