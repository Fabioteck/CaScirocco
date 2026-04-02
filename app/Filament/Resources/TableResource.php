<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TableResource\Pages;
use App\Filament\Resources\TableResource\RelationManagers;
use App\Models\Table;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table as FilamentTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TableResource extends Resource
{
    protected static ?string $model = Table::class;

    protected static ?string $navigationGroup = 'Ristorante';
    protected static ?string $navigationIcon = 'heroicon-o-table-cells';
    protected static ?int $navigationSort = 6;

    protected static ?string $navigationLabel = 'Gestione tavoli';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\Select::make('dining_area_id')
                    ->relationship('diningArea', 'name')
                    ->required(),
                Forms\Components\TextInput::make('capacity')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(FilamentTable $table): FilamentTable
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('diningArea.name'),
                Tables\Columns\TextColumn::make('capacity'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('dining_area_id')
                    ->relationship('diningArea', 'name'),
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
            'index' => Pages\ListTables::route('/'),
            'create' => Pages\CreateTable::route('/create'),
            'edit' => Pages\EditTable::route('/{record}/edit'),
        ];
    }
}