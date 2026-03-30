<?php

namespace App\Filament\Resources\DailyDishResource\Pages;

use App\Filament\Resources\DailyDishResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDailyDishes extends ListRecords
{
    protected static string $resource = DailyDishResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
