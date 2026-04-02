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

    protected static ?string $navigationGroup = 'Ristorante';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Gestione sale';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('description'),
                Forms\Components\TextInput::make('capacity')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('capacity'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListDiningAreas::route('/'),
            'create' => Pages\CreateDiningArea::route('/create'),
            'edit' => Pages\EditDiningArea::route('/{record}/edit'),
        ];
    }
}