<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WineResource\Pages;
use App\Models\Wine;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;

class WineResource extends Resource
{
    protected static ?string $model = Wine::class;

    protected static ?string $navigationLabel = 'Carta dei vini';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'ATTIVITA\'';
    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $slug = 'wines';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Dati Vino')
                    ->tabs([
                        Tabs\Tab::make('Identità e Origine')
                            ->schema([
                                TextInput::make('name')->label('Nome Vino')->required(),
                                TextInput::make('producer')->label('Produttore')->required(),
                                TextInput::make('vintage')->label('Annata')->default('NV'),
                                Select::make('type')->label('Tipologia')
                                    ->options([
                                        'Rosso' => 'Rosso', 'Bianco' => 'Bianco', 
                                        'Bollicine' => 'Bollicine', 'Rosato' => 'Rosato'
                                    ]),
                                TextInput::make('classification')->label('Classificazione (DOCG, IGT...)'),
                                TextInput::make('region')->label('Regione'),
                            ])->columns(2),

                        Tabs\Tab::make('Logistica e Prezzi')
                            ->schema([
                                TextInput::make('price_bottle')->numeric()->prefix('€')->label('Prezzo Bottiglia'),
                                TextInput::make('price_glass')->numeric()->prefix('€')->label('Prezzo Calice'),
                                TextInput::make('stock')->numeric()->default(0)->label('Giacenza Stock'),
                                Toggle::make('is_available')->label('Disponibile nel Menu')->default(true),
                                TextInput::make('sku')->label('Codice Interno / SKU'),
                            ])->columns(2),

                        Tabs\Tab::make('Caratteristiche')
                            ->schema([
                                Select::make('body')->label('Corpo (1-5)')
                                    ->options([1=>1, 2=>2, 3=>3, 4=>4, 5=>5]),
                                Textarea::make('tasting_notes')->label('Note Olfattive/Gusto'),
                                FileUpload::make('label_image')
                                    ->label('Foto Etichetta')
                                    ->image() // Forza il formato immagine
                                    ->imageEditor() // Permette di ritagliare la foto direttamente nel browser!
                                    ->directory('wines') // Crea una cartella pulita in storage/app/public/wines
                                    ->visibility('public'),
                            ]),
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Vino')
                    ->description(fn (Wine $record): string => $record->producer),
                
                Tables\Columns\TextColumn::make('type')->badge(),

                Tables\Columns\TextInputColumn::make('stock')
                    ->label('Giacenza')
                    ->type('number'),

                Tables\Columns\ToggleColumn::make('is_available')
                    ->label('In Menù'),

                Tables\Columns\TextColumn::make('price_bottle')
                    ->money('eur')
                    ->label('Prezzo'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options(['Rosso' => 'Rosso', 'Bianco' => 'Bianco', 'Bollicine' => 'Bollicine']),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWines::route('/'),
            'create' => Pages\CreateWine::route('/create'),
            'edit' => Pages\EditWine::route('/{record}/edit'),
        ];
    }
}
