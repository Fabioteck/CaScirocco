<?php

namespace App\Filament\Resources\TableBookingResource\Pages;

use App\Filament\Resources\TableBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTableBooking extends EditRecord
{
    protected static string $resource = TableBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
