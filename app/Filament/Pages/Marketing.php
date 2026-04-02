<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class Marketing extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationLabel = 'Marketing & QR';

    protected static ?string $navigationGroup = 'Ristorante';

    protected static ?int $navigationSort = 4;

    protected static string $view = 'filament.pages.marketing';

    public function getQrCode()
    {
        // Usiamo il percorso completo per evitare che PHP faccia confusione
        return \SimpleSoftwareIO\QrCode\Facades\QrCode::size(300)
            ->color(124, 45, 18) // Arancio Cà Scirocco
            ->margin(2)
            ->generate(url('/menu-digitale'));
    }
}
