<?php

namespace App\Filament\Resources\DailyMenuSelectionResource\Pages;

use App\Filament\Resources\DailyMenuSelectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDailyMenuSelections extends ListRecords
{
    protected static string $resource = DailyMenuSelectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
