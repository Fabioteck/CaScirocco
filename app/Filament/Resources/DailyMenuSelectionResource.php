<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DailyMenuSelectionResource\Pages;
use App\Filament\Resources\DailyMenuSelectionResource\RelationManagers;
use App\Models\DailyMenuSelection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DailyMenuSelectionResource extends Resource
{
    protected static ?string $model = DailyMenuSelection::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\DatePicker::make('available_at')
                ->label('Data Menù')
                ->default(now())
                ->required(),
            
            Forms\Components\Select::make('dish_id')
                ->label('Pesca dal Menù Fisso')
                ->relationship('dish', 'name') // Questo collega le due tabelle!
                ->searchable()
                ->preload()
                ->helperText('Lascia vuoto se vuoi inserire un fuori menù qui sotto'),

            Forms\Components\TextInput::make('custom_name')
                ->label('Nome (Solo per Fuori Menù)')
                ->helperText('Usa questo se il piatto non è nel menù fisso'),

            Forms\Components\TextInput::make('custom_price')
                ->numeric()
                ->prefix('€')
                ->label('Prezzo Speciale'),
        ]);
}


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
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
        return [
            //
        ];
    }

    public function dish()
{
    return $this->belongsTo(Dish::class);
}


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDailyMenuSelections::route('/'),
            'create' => Pages\CreateDailyMenuSelection::route('/create'),
            'edit' => Pages\EditDailyMenuSelection::route('/{record}/edit'),
        ];
    }
}
