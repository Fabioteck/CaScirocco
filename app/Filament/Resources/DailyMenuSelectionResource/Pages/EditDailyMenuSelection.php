<?php

namespace App\Filament\Resources\DailyMenuSelectionResource\Pages;

use App\Filament\Resources\DailyMenuSelectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDailyMenuSelection extends EditRecord
{
    protected static string $resource = DailyMenuSelectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
