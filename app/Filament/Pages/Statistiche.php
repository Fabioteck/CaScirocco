<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;


class Statistiche extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar-square';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Statistiche';

    protected static ?string $navigationGroup = null;
    protected static string $view = 'filament.pages.statistiche';
}
