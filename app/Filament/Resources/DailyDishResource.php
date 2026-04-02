<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DailyDishResource\Pages;
use App\Filament\Resources\DailyDishResource\RelationManagers;
use App\Models\DailyDish;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DailyDishResource extends Resource
{
    protected static ?string $model = DailyDish::class;

    protected static ?string $navigationGroup = 'Ristorante';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Menu del giorno';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('menu_date')->required(),
                Forms\Components\Select::make('dish_id')
                    ->relationship('dish', 'name')
                    ->required(),
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
                Tables\Columns\TextColumn::make('menu_date')->date('d/m/Y'),
                Tables\Columns\TextColumn::make('dish.name'),
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
            'index' => Pages\ListDailyDishes::route('/'),
            'create' => Pages\CreateDailyDish::route('/create'),
            'edit' => Pages\EditDailyDish::route('/{record}/edit'),
        ];
    }
}