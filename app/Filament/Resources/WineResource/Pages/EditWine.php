<?php

namespace App\Filament\Resources\WineResource\Pages;

use App\Filament\Resources\WineResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWine extends EditRecord
{
    protected static string $resource = WineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
