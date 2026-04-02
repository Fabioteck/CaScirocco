<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TableBookingResource\Pages;
use App\Filament\Resources\TableBookingResource\RelationManagers;
use App\Models\TableBooking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TableBookingResource extends Resource
{
    protected static ?string $model = TableBooking::class;

    protected static ?string $navigationGroup = 'Amministrazione';
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Prenotazione tavoli';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('table_id')
                    ->relationship('table', 'name')
                    ->required(),
                Forms\Components\TextInput::make('customer_name')->required(),
                Forms\Components\TextInput::make('customer_email')->email()->required(),
                Forms\Components\DateTimePicker::make('booking_time')
                    ->required()
                    ->native(false),
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
                Tables\Columns\TextColumn::make('table.name'),
                Tables\Columns\TextColumn::make('booking_time')->dateTime('d/m/Y H:i')->sortable(),
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
            'index' => Pages\ListTableBookings::route('/'),
            'create' => Pages\CreateTableBooking::route('/create'),
            'edit' => Pages\EditTableBooking::route('/{record}/edit'),
        ];
    }
}