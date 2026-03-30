<?php

namespace App\Filament\Resources\DailyDishResource\Pages;

use App\Filament\Resources\DailyDishResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDailyDish extends CreateRecord
{
    protected static string $resource = DailyDishResource::class;
}
