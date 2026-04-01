<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationLabel = 'Prenotazione stanze';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'MENU';

  public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Select::make('room_id')
                ->relationship('room', 'name')
                ->required(),
            Forms\Components\TextInput::make('customer_name')->required(),
            Forms\Components\TextInput::make('customer_email')->email()->required(),
            Forms\Components\DatePicker::make('check_in')
                ->required()
                ->native(false) // Più bello su mobile
                ->displayFormat('d/m/Y'),
            Forms\Components\DatePicker::make('check_out')
                ->required()
                ->native(false)
                ->displayFormat('d/m/Y'),
            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'In Attesa',
                    'confirmed' => 'Confermata',
                    'cancelled' => 'Annullata',
                ])->default('pending')->required(),
        ]);
}


   public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('customer_name')->searchable(),
            Tables\Columns\TextColumn::make('room.name'),
            Tables\Columns\TextColumn::make('check_in')->date('d/m/Y')->sortable(),
            Tables\Columns\TextColumn::make('check_out')->date('d/m/Y')->sortable(),
            Tables\Columns\BadgeColumn::make('status')
                ->colors([
                    'warning' => 'pending',
                    'success' => 'confirmed',
                    'danger' => 'cancelled',
                ]),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status')
                ->options(['pending' => 'In Attesa', 'confirmed' => 'Confermate']),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
