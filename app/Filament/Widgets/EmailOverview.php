<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Webklex\IMAP\Facades\Client;
use Exception;

class EmailOverview extends BaseWidget
{
    // Aumentiamo il polling a 60 secondi per non stressare il Raspberry
    protected static ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        try {
            // Tentativo di connessione con l'account 'default' definito nel .env
            $client = Client::account('default');
            
            // Verifichiamo la connessione (fondamentale per evitare crash)
            $client->connect();

            // Puntiamo alla INBOX
            $folder = $client->getFolder('INBOX');

            // Otteniamo i conteggi
            // Nota: count() su query() è molto più veloce di get()->count()
            $totalEmails = $folder->query()->all()->count();
            $unreadEmails = $folder->query()->unseen()->count();

            return [
                Stat::make('Email Totali', $totalEmails)
                    ->description('Messaggi in arrivo')
                    ->icon('heroicon-o-envelope'),
                Stat::make('Da Leggere', $unreadEmails)
                    ->description($unreadEmails > 0 ? 'Hai nuovi messaggi' : 'Tutto letto')
                    ->color($unreadEmails > 0 ? 'warning' : 'success')
                    ->icon($unreadEmails > 0 ? 'heroicon-o-envelope-open' : 'heroicon-o-check-circle'),
            ];

        } catch (Exception $e) {
            // Log dell'errore per debug (lo trovi in storage/logs/laravel.log)
            \Log::error("Errore IMAP Dashboard: " . $e->getMessage());

            return [
                Stat::make('Email', 'Offline')
                    ->description('Connessione fallita')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle'),
            ];
        }
    }
}
