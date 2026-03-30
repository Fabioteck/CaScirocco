<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Models\Room;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;
    protected static ?string $navigationLabel = 'Gestione stanze';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationGroup = 'ATTIVITA\'';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dettagli Stanza')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->label('Nome Stanza'),
                        
                        Forms\Components\TextInput::make('capacity')
                            ->numeric()
                            ->required()
                            ->label('Posti Letto')
                            ->prefixIcon('heroicon-o-users'),

                        Forms\Components\TextInput::make('price_per_night')
                            ->numeric()
                            ->prefix('€')
                            ->label('Prezzo per Notte')
                            ->required(),
                    ])->columns(3),

                    Forms\Components\Section::make('Descrizione')
                    ->schema([
                        Forms\Components\RichEditor::make('description')
                            ->label('Descrizione Stanza')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Galleria Immagini')
                    ->description('Trascina qui fino a 10 foto.')
                    ->schema([])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome')->sortable(),
                Tables\Columns\TextColumn::make('capacity')->label('Posti')->sortable(),
                Tables\Columns\TextColumn::make('price_per_night')->label('Prezzo')->money('EUR'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
