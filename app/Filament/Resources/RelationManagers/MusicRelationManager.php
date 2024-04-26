<?php

namespace App\Filament\Resources\RelationManagers;

use App\Filament\Resources\MusicResource;
use App\Models\Artist;
use App\Models\Instrument;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class MusicRelationManager extends RelationManager
{
    protected static string $relationship = 'musics';

    public function form(Form $form): Form
    {
        return MusicResource::form($form);
    }

    public function table(Table $table): Table
    {
        return MusicResource::table($table)
            ->headerActions([
                    Tables\Actions\CreateAction::make()->fillForm(function(array $data) {
                        $ownerRecord = $this->getOwnerRecord();
                        if( $ownerRecord instanceof Artist) {
                            $data['artist_id'] = $ownerRecord->getKey();
                        }
                        if( $ownerRecord instanceof Instrument) {
                            $data['instruments'][] = $ownerRecord->getKey();
                        }
                    return $data;
                })
            ]);
    }
}
