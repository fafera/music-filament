<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MusicResource\Pages;
use App\Models\Music;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class MusicResource extends Resource
{
    protected static ?string $model = Music::class;

    protected static ?string $modelLabel = 'Músicas';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema(self::getFormSchema());
    }

    public static function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('title')->label('Título')
                                      ->required(),
            Forms\Components\Select::make('artist_id')
                                   ->relationship('artist', 'title')
                                   ->searchable()->preload()->createOptionForm([
                    Forms\Components\TextInput::make('title')->required()
                                              ->maxLength(255)->unique()
                ])->editOptionForm([
                    Forms\Components\TextInput::make('title')->required()
                                              ->maxLength(255)

                ])->label('Artista/Banda')->required(),
            Forms\Components\Select::make('instruments')
                                   ->relationship('instruments', 'title')
                                   ->searchable()->preload()->multiple()
                                   ->createOptionForm([
                                       Forms\Components\TextInput::make('title')
                                                                 ->required()
                                                                 ->maxLength(255)
                                                                 ->unique()
                                   ])->label('Instrumentos')->required(),
            Forms\Components\Select::make('key')->options(self::getMusicKeys())
                                   ->label('Tonalidade')->required(),
            Forms\Components\Select::make('genres')
                                   ->relationship('genres', 'title')
                                   ->searchable()->preload()->multiple()
                                   ->createOptionForm([
                                       Forms\Components\TextInput::make('title')
                                                                 ->required()
                                                                 ->maxLength(255)
                                                                 ->unique()
                                   ])->label('Estilo')->required(),
            Forms\Components\FileUpload::make('file')->disk('public')
                                       ->directory('files')->openable()
                                       ->downloadable()
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('title')->searchable(),
            Tables\Columns\TextColumn::make('file'),
            Tables\Columns\TextColumn::make('artist.title')->searchable(),
            Tables\Columns\TextColumn::make('instruments.title')->searchable(),
            Tables\Columns\TextColumn::make('genres.title')->searchable(),

        ];
    }

    public static function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('artist')->label('Artista')
                                       ->relationship('artist', 'title'),
            Tables\Filters\SelectFilter::make('instruments')
                                       ->label('Instrumento')->multiple()
                                       ->preload()
                                       ->relationship('instruments', 'title'),
            Tables\Filters\SelectFilter::make('genres')->label('Estilo')
                                       ->multiple()->preload()
                                       ->relationship('genres', 'title'),
            Tables\Filters\SelectFilter::make('key')->label('Tonalidade')
                                       ->multiple()
                                       ->options(self::getMusicKeys())
                                       ->preload()

        ];
    }

    public static function table(Table $table): Table
    {
        return $table->columns(self::getTableColumns())
                     ->filters(self::getTableFilters())->actions([
            Tables\Actions\ActionGroup::make([
                Tables\Actions\EditAction::make()->label('Editar'),
                Tables\Actions\DeleteAction::make()->label('Deletar'),
                Tables\Actions\Action::make('donwloadFile')
                                     ->label('Baixar arquivo')
                                     ->action(function ($record) {
                                         return Storage::disk('public')
                                                       ->download($record->file);
                                     })->color('primary')
                                     ->icon('heroicon-s-folder-arrow-down')
            ])->button()->label('Ações'),
        ])->bulkActions([
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
            'index'  => Pages\ListMusic::route('/'),
            'create' => Pages\CreateMusic::route('/create'),
            'edit'   => Pages\EditMusic::route('/{record}/edit')
        ];
    }

    public static function getMusicKeys(): array
    {
        return [
            'a' => 'A', 'b' => 'B', 'c' => 'C', 'd' => 'D', 'e' => 'E',
            'f' => 'F', 'g' => 'G'
        ];
    }
}
