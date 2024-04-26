<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\MusicResource;
use App\Models\Music;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class MusicsDashboard extends BaseWidget
{

    public function table(Table $table): Table
    {
        return MusicResource::table($table)->query(Music::query())->actions([
            Tables\Actions\EditAction::make('edit')->form(MusicResource::getFormSchema())
//            Action::make('edit')
//                  ->url(fn (Music $record): string => route('filament.admin.resources.music.edit', $record))->modal(true)
        ]);
    }
    public function form(Form $form): Form
    {
        return MusicResource::form($form);
    }
}
