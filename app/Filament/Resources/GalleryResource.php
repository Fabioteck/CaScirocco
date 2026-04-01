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
    protected static ?string $navigationGroup = 'Sito';
    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

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
                ->image()
                ->disk('public')
                ->directory('galleries')
                ->visibility('public')
                ->imageResizeTargetWidth('1200') // Fondamentale per le performance del Pi 4
                ->imageResizeTargetHeight('800')
                ->loadingIndicatorPosition('left')
                ->panelLayout('integrated')
                ->required(),

            TextInput::make('title')
                ->label('Titolo (opzionale)')
                ->maxLength(255),

            TextInput::make('sort_order')
                ->label('Ordine')
                ->numeric()
                ->default(0)
                ->required(),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->disk('public')
                    ->label('Foto')
                    ->square(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Titolo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoria'),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Ordine')
                    ->sortable(),
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
