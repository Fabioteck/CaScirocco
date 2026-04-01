<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DishResource\Pages;
use App\Models\Dish;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DishResource extends Resource
{
    protected static ?string $model = Dish::class;

    protected static ?string $navigationLabel = 'Piatti';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Ristorante';
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required()->label('Nome'),
                Forms\Components\Select::make('category')
                    ->options([
                        'Antipasti' => 'Antipasti',
                        'Primi' => 'Primi',
                        'Secondi' => 'Secondi',
                        'Contorni' => 'Contorni',
                        'Dessert' => 'Dessert',
                    ])->required()->label('Portata'),
                Forms\Components\TextInput::make('price')->numeric()->required()->prefix('€'),
                Forms\Components\Toggle::make('is_daily')->label('Menù del Giorno'),
                Forms\Components\FileUpload::make('image')->image()->directory('dishes'),
                Forms\Components\Textarea::make('description')->columnSpanFull(),
            ]);
    }

            public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Nome del Piatto
                Tables\Columns\TextColumn::make('name')
                    ->label('Nome Piatto')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                // Portata (con bollino colorato)
                Tables\Columns\TextColumn::make('category')
                    ->label('Portata')
                    ->badge()
                    ->color('warning'),

                // Prezzo
                Tables\Columns\TextColumn::make('price')
                    ->label('Prezzo')
                    ->money('eur')
                    ->sortable(),

                // Switch per attivarlo/disattivarlo dal Menù del Giorno con un click
                Tables\Columns\ToggleColumn::make('is_daily')
                    ->label('Al Menù Giorno'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDishes::route('/'),
            'create' => Pages\CreateDish::route('/create'),
            'edit' => Pages\EditDish::route('/{record}/edit'),
        ];
    }
}
