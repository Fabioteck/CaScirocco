<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WineResource\Pages;
use App\Filament\Resources\WineResource\RelationManagers;
use App\Models\Wine;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WineResource extends Resource
{
    protected static ?string $model = Wine::class;

    protected static ?string $navigationGroup = 'Ristorante';
    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Carta dei vini';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('description')->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'Rosso' => 'Rosso',
                        'Bianco' => 'Bianco',
                        'Rosato' => 'Rosato',
                        'Spumante' => 'Spumante',
                    ])->required(),
                Forms\Components\Toggle::make('is_available')->label('Disponibile'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\ToggleColumn::make('is_available'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'Rosso' => 'Rosso',
                        'Bianco' => 'Bianco',
                        'Rosato' => 'Rosato',
                        'Spumante' => 'Spumante',
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
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