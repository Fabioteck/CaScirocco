<?php

namespace App\Filament\Pages;

use App\Models\Setting; 
use Filament\Pages\Page;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor; // Aggiunto import mancante
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Notifications\Notification;

class Settings extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Settaggi';

    protected static ?string $navigationGroup = 'GESTIONE SITO';

    protected static ?int $navigationSort = 3;

    protected static ?string $title = 'Impostazioni Generali';

    protected static string $view = 'filament.pages.settings';

    public ?array $data = [];

    public function mount(): void
    {
        // Recupera i settaggi esistenti e popola il form
        $this->form->fill(
            Setting::all()->pluck('value', 'key')->toArray()
        );
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // SEZIONE 1: ORARI
                Section::make('Orari Ristorante')
                    ->description('Gestisci quando i clienti possono prenotare a Ca\' Scirocco')
                    ->schema([
                        Select::make('giorno_chiusura')
                            ->label('Giorno di Chiusura')
                            ->options([
                                'lunedi' => 'Lunedì',
                                'martedi' => 'Martedì',
                                'mercoledi' => 'Mercoledì',
                                'giovedi' => 'Giovedì',
                                'venerdi' => 'Venerdì',
                                'sabato' => 'Sabato',
                                'domenica' => 'Domenica',
                            ]),
                        TimePicker::make('apertura_pranzo')
                            ->label('Inizio Pranzo'),
                        TimePicker::make('apertura_cena')
                            ->label('Inizio Cena'),
                    ])->columns(3),

                // SEZIONE 2: EMAIL (Ora inserita correttamente dentro lo schema)
                Section::make('Template Email Conferma')
                    ->description('Personalizza il messaggio che riceve il cliente per la stanza')
                    ->schema([
                        TextInput::make('email_subject')
                            ->label('Oggetto Email')
                            ->placeholder('Esempio: Conferma Prenotazione Ca\' Scirocco'),
                        RichEditor::make('email_body')
                            ->label('Corpo del Messaggio')
                            ->helperText('Usa il tag {customer_name} per inserire il nome del cliente nel testo.')
                            ->columnSpanFull(),
                    ]),

                    Section::make('Template Email Ristorante')
                    ->description('Personalizza il messaggio per la conferma dei tavoli')
                    ->schema([
                        TextInput::make('email_restaurant_subject')
                            ->label('Oggetto Email Tavolo')
                            ->placeholder('Esempio: Il tuo tavolo a Ca\' Scirocco è confermato'),
                        RichEditor::make('email_restaurant_body')
                            ->label('Corpo del Messaggio Tavolo')
                            ->helperText('Usa i tag {customer_name} per il nome e {people_count} per il numero di persone.')
                            ->columnSpanFull(),
                    ])->collapsible(),
            
                    Section::make('Chiusura Straordinaria (Ferie)')
                        ->description('Imposta un periodo in cui il sito non accetterà prenotazioni')
                        ->schema([
                            \Filament\Forms\Components\DatePicker::make('ferie_inizio')
                                ->label('Inizio Chiusura'),
                            \Filament\Forms\Components\DatePicker::make('ferie_fine')
                                ->label('Fine Chiusura'),
                            \Filament\Forms\Components\Toggle::make('chiusura_totale')
                                ->label('Blocca Tutto Immediatamente')
                                ->helperText('Usa questo per chiusure d\'emergenza non programmate')
                                ->onColor('danger'),
                        ])->columns(3),
                    ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Salva Impostazioni')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        Notification::make()
            ->title('Settaggi di Ca\' Scirocco salvati!')
            ->success()
            ->send();
    }
}
