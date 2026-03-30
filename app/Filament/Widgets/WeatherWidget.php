<?php
namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Http;

class WeatherWidget extends BaseWidget
{
    protected static ?int $sort = 2; // Seconda riga

    protected function getStats(): array
    {
        try {
            $response = Http::timeout(3)->get('https://api.open-meteo.com', [ // <--- Aggiunto /v1/forecast
                        'latitude' => 45.05,
                        'longitude' => 12.05,
                        'current_weather' => true,
                    ]);
            $weather = $response->json()['current_weather'] ?? null;
            if (!$weather) throw new \Exception();

            $temp = round($weather['temperature']);
            $code = $weather['weathercode'];

            $status = match(true) {
                $code == 0 => ['label' => 'Soleggiato', 'icon' => 'heroicon-m-sun', 'color' => 'warning'],
                $code <= 3 => ['label' => 'Nuvoloso', 'icon' => 'heroicon-m-cloud', 'color' => 'gray'],
                $code >= 51 && $code <= 67 => ['label' => 'Pioggia', 'icon' => 'heroicon-m-cloud-arrow-down', 'color' => 'info'],
                default => ['label' => 'Variabile', 'icon' => 'heroicon-m-sun', 'color' => 'success'],
            };

            return [
                Stat::make('Meteo Adria', "{$temp}°C")
                    ->description($status['label'])
                    ->descriptionIcon($status['icon'])
                    ->color($status['color']),
            ];
        } catch (\Exception $e) {
            return [Stat::make('Meteo', 'N/D')->description('Servizio meteo offline')->color('gray')];
        }
    }
}
