<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationGroup = 'Amministrazione';

    /**
     * Widget visibili in Dashboard:
     * Carichiamo solo lo StatsOverview (i 6 riquadri organizzati 3x2).
     */
    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatsOverview::class,
        ];
    }

    /**
     * Pulizia totale: restituiamo un array vuoto per far sparire 
     * i bottoni colorati in alto a destra.
     */
    protected function getHeaderActions(): array
    {
        return [];
    }
}
