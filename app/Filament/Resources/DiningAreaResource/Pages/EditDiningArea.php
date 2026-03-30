<?php

namespace App\Filament\Resources\DiningAreaResource\Pages;

use App\Filament\Resources\DiningAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDiningArea extends EditRecord
{
    protected static string $resource = DiningAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
