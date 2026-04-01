<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TableBookingResource\Pages;
use App\Models\TableBooking;
use App\Models\DiningArea;
use App\Models\Table as RestaurantTable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class TableBookingResource extends Resource
{
    protected static ?string $model = TableBooking::class;
    protected static ?string $navigationLabel = 'Prenotazione tavoli';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'MENU';

    protected static bool $shouldRegisterNavigation = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Dati Cliente')
                    ->schema([
                        Forms\Components\TextInput::make('customer_name')
                            ->label('Nome Cliente')
                            ->required()
                            ->placeholder('es. Mario Rossi'),
                        Forms\Components\TextInput::make('phone')
                            ->label('Telefono/Contatto')
                            ->tel(),
                    ])->columns(2),

                Forms\Components\Section::make('Dettagli Tavolo')
                    ->schema([
                        Forms\Components\TextInput::make('pax')
                            ->label('Persone')
                            ->numeric()
                            ->default(2)
                            ->required()
                            ->reactive(), 

                        Forms\Components\DateTimePicker::make('reservation_time')
                            ->label('Data e Ora')
                            ->default(Carbon::now()->setHour(20)->setMinute(0))
                            ->required(),

                        // Filtro per Sala (Polesine Style)
                        Forms\Components\Select::make('dining_area_id')
                            ->label('Sala (Camino o Centrale)')
                            ->options(DiningArea::pluck('name', 'id'))
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('table_id', null)),

                        // Mostra solo i tavoli adatti
                        Forms\Components\Select::make('table_id')
                            ->label('Assegna Tavolo')
                            ->placeholder('Scegli tavolo...')
                            ->options(function (callable $get) {
                                $areaId = $get('dining_area_id');
                                $pax = $get('pax');
                                
                                if (!$areaId) return [];

                                return RestaurantTable::where('dining_area_id', $areaId)
                                    ->where('max_capacity', '>=', $pax)
                                    ->where('is_active', true)
                                    ->pluck('table_number', 'id');
                            })
                            ->required(),
                    ])->columns(2),

                Forms\Components\Select::make('status')
                    ->label('Stato')
                    ->options([
                        'confirmed' => 'Confermata',
                        'pending' => 'In Attesa',
                        'cancelled' => 'Annullata',
                    ])
                    ->default('confirmed')
                    ->required(),

                Forms\Components\Textarea::make('notes')
                    ->label('Note (Allergie, Camino, ecc.)')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reservation_time')
                    ->label('Data e Ora')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Cliente')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('pax')
                    ->label('Persone')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('table.table_number')
                    ->label('Tavolo')
                    ->badge()
                    ->color('warning'),

                Tables\Columns\SelectColumn::make('status')
                    ->label('Stato')
                    ->options([
                        'confirmed' => 'Confermata',
                        'pending' => 'In Attesa',
                        'cancelled' => 'Annullata',
                    ]),
            ])
            ->defaultSort('reservation_time', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'confirmed' => 'Confermata',
                        'pending' => 'In Attesa',
                        'cancelled' => 'Annullata',
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

    public static function getRelations(): array
    {
        return [];
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
