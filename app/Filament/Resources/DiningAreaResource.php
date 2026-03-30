<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DiningAreaResource\Pages;
use App\Filament\Resources\DiningAreaResource\RelationManagers;
use App\Models\DiningArea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DiningAreaResource extends Resource
{
    protected static ?string $model = DiningArea::class;
    protected static ?string $navigationLabel = 'Gestione sale';
    protected static ?int $navigationSort = 4;
    protected static ?string $slug = 'dining-areas';
    protected static ?string $navigationGroup = 'ATTIVITA\'';
    protected static bool $shouldRegisterNavigation = true; 

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

        public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dettagli Sala')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nome della Sala')
                            ->required()
                            ->placeholder('es. Sala Camino Nord'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome Sala')
                    ->sortable()
                    ->searchable(),
                
                // Conteggio dei tavoli associati per ogni sala
                Tables\Columns\TextColumn::make('tables_count')
                    ->label('Tavoli Totali')
                    ->counts('tables')
                    ->badge()
                    ->color('info'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDiningAreas::route('/'),
            'create' => Pages\CreateDiningArea::route('/create'),
            'edit' => Pages\EditDiningArea::route('/{record}/edit'),
        ];
    }
}
