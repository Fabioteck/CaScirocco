<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DishResource\Pages;
use App\Filament\Resources\DishResource\RelationManagers;
use App\Models\Dish;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DishResource extends Resource
{
    protected static ?string $model = Dish::class;

    protected static ?string $navigationGroup = 'Ristorante';
    protected static ?string $navigationIcon = 'heroicon-o-cake';
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Piatti';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('description')->required(),
                Forms\Components\Select::make('category')
                    ->options([
                        'Antipasti' => 'Antipasti',
                        'Primi' => 'Primi',
                        'Secondi' => 'Secondi',
                        'Contorni' => 'Contorni',
                        'Dessert' => 'Dessert',
                    ])->required(),
                Forms\Components\Toggle::make('is_active')->label('Attivo'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('category'),
                Tables\Columns\ToggleColumn::make('is_active'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'Antipasti' => 'Antipasti',
                        'Primi' => 'Primi',
                        'Secondi' => 'Secondi',
                        'Contorni' => 'Contorni',
                        'Dessert' => 'Dessert',
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
            'index' => Pages\ListDishes::route('/'),
            'create' => Pages\CreateDish::route('/create'),
            'edit' => Pages\EditDish::route('/{record}/edit'),
        ];
    }
}