<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Filament\Resources\GalleryResource\RelationManagers;
use App\Models\Gallery;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationLabel = 'Gallerie';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'GESTIONE SITO';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

public static function form(Form $form): Form
{
    return $form
        ->schema([
            // Seleziona la categoria (Relazione)
            Select::make('category_id')
                ->relationship('category', 'name')
                ->required()
                ->searchable()
                ->preload(),

            // Il cuore dell'upload
            FileUpload::make('image_path')
                ->label('Carica Immagine')
                ->image() // Accetta solo immagini
                ->multiple() // Carica tutto il set del "Museo" in un colpo solo
                ->reorderable() // Trascina le foto per decidere l'ordine
                ->directory('gallery-cascirocco') // Cartella in storage/app/public/
                ->imageResizeTargetWidth('1200') // Fondamentale per le performance del Pi 4
                ->imageResizeTargetHeight('800')
                ->loadingIndicatorPosition('left')
                ->panelLayout('integrated') // Visualizzazione compatta
                ->required(),

            TextInput::make('title')
                ->label('Titolo (opzionale)')
                ->maxLength(255),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
