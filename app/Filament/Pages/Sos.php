<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Sos extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';
    
    protected static ?string $navigationLabel = 'SOS';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationGroup = 'Amministrazione';

    protected static string $view = 'filament.pages.sos';
}
