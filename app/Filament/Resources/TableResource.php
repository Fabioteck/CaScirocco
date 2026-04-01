<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TableResource\Pages;
use App\Models\Table as TableModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class TableResource extends Resource
{
    protected static ?string $model = TableModel::class;
    protected static ?string $navigationLabel = 'Gestione tavoli';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationGroup = 'Ristorante';
    
    protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Configurazione Tavolo')
                    ->schema([
                        // Allineato alla colonna 'name' del tuo DB
                        Forms\Components\TextInput::make('name')
                            ->label('Nome/Numero Tavolo')
                            ->required(),
                        
                        // Il Ponte con le Sale (Camini, Centrale, ecc.)
                        Forms\Components\Select::make('dining_area_id')
                            ->label('Sala / Zona')
                            ->relationship('diningArea', 'name')
                            ->preload()
                            ->required(),

                        Forms\Components\TextInput::make('max_capacity')
                            ->label('Capacità Massima')
                            ->numeric()
                            ->default(4),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Attivo')
                            ->default(true),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Allineato alla colonna 'name' del tuo DB
                TextColumn::make('name')
                    ->label('Tavolo')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                // La Stanza Associata (Visualizzazione Badge)
                TextColumn::make('diningArea.name')
                    ->label('Stanza / Zona')
                    ->badge()
                    ->color('warning')
                    ->sortable()
                    ->placeholder('Nessuna sala'),

                TextColumn::make('max_capacity')
                    ->label('Coperti Max')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),

                IconColumn::make('is_active')
                    ->label('Stato')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->filters([
                // Filtro rapido per Sala
                Tables\Filters\SelectFilter::make('dining_area_id')
                    ->label('Filtra per Stanza')
                    ->relationship('diningArea', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTables::route('/'),
            'create' => Pages\CreateTable::route('/create'),
            'edit' => Pages\EditTable::route('/{record}/edit'),
        ];
    }
}
