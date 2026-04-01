<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DailyDishResource\Pages;
use App\Models\DailyDish;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;


class DailyDishResource extends Resource
{
    protected static ?string $model = DailyDish::class;
    protected static ?string $navigationLabel = 'Menu del giorno';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Ristorante';
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static bool $shouldRegisterNavigation = true;
    protected static ?string $slug = 'daily-dishes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dettagli Piatto')
                    ->schema([
                        FileUpload::make('image_path')
                                ->label('Foto del Piatto')
                                ->image()
                                ->imageEditor()
                                ->imageCropAspectRatio('16:9')
                                ->directory('dishes'),
                        TextInput::make('name')->label('Nome Piatto')->required(),
                        Select::make('category')->label('Categoria')
                            ->options([
                                'Antipasto' => 'Antipasto', 'Primo' => 'Primo', 
                                'Secondo' => 'Secondo', 'Contorno' => 'Contorno', 
                                'Dessert' => 'Dessert', 'Fuori Carta' => 'Fuori Carta'
                            ])->required(),
                        TextInput::make('price')->numeric()->prefix('€')->required(),
                        DatePicker::make('menu_date')->label('Data')->default(now())->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Il Ponte: Abbinamento Vino')
                    ->schema([
                        Select::make('suggested_wine_id')
                            ->label('Vino Consigliato')
                            ->relationship('suggestedWine', 'name')
                            ->searchable() // Cerca tra i vini che abbiamo appena popolato!
                            ->preload()
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->name} ({$record->producer})"),
                    ]),

                Forms\Components\Section::make('Stato')
                    ->schema([
                        Toggle::make('is_out_of_stock')->label('Esaurito')->onColor('danger'),
                        Toggle::make('is_active')->label('Attivo nel Menù')->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->label('Piatto'),
                Tables\Columns\TextColumn::make('category')->badge()->label('Portata'),
                Tables\Columns\TextColumn::make('price')->money('eur')->label('Prezzo'),
                Tables\Columns\TextColumn::make('suggestedWine.name')->label('Vino Abbinato')->placeholder('Nessuno'),
                Tables\Columns\ToggleColumn::make('is_out_of_stock')->label('Esaurito'),
            ])
            ->filters([
                Tables\Filters\Filter::make('oggi')
                    ->query(fn ($query) => $query->whereDate('menu_date', now()))
                    ->label('Menù di Oggi'),
            ]);
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
