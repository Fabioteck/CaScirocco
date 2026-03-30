<?php

namespace App\Filament\Widgets;

use App\Models\Setting;
use Filament\Widgets\Widget;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class FerieWidget extends Widget implements HasForms
{
    use InteractsWithForms;

    // Ordine 2: Sotto i contatori (che hanno 1)
    protected static ?int $sort = 2; 

    // Occupa tutta la larghezza sotto i quadrati
    protected int | string | array $columnSpan = 'full';

    protected static string $view = 'filament.widgets.ferie-widget';

    public ?array $data = [];

    public function mount(): void
    {
        // Carica le date e lo stato salvati
        $this->form->fill(
            Setting::all()->pluck('value', 'key')->toArray()
        );
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Blocco Rapido Prenotazioni (Ferie / Emergenza)')
                    ->description('Gestisci la chiusura del sito da qui senza entrare nei Settaggi')
                    ->schema([
                        DatePicker::make('ferie_inizio')->label('Inizio Chiusura')->native(false),
                        DatePicker::make('ferie_fine')->label('Fine Chiusura')->native(false),
                        Toggle::make('chiusura_totale')
                            ->label('Blocca Tutto Immediatamente')
                            ->onColor('danger')
                            ->inline(false),
                    ])->columns(3),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        Notification::make()
            ->title('Stato chiusura aggiornato con successo!')
            ->success()
            ->send();
    }
}
