<?php

namespace App\Livewire;

use App\Clients\ChatGPT;
use App\Filament\Resources\MusicResource;
use App\Models\Music;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Spatie\PdfToText\Pdf;


class UploadFile extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    public ?array $data = [];

    public function mount(): void
    {
        $chatgpt = ChatGPT::getInstance()->chat('oi, me diga alguma coisa para ver se funcionou');
        dd($chatgpt);
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            FileUpload::make('file')->live()->afterStateUpdated(function () {
                $this->handleFileUpload();
            })->disk('public')->directory('files')->preserveFilenames(true)
                      ->visibility('public')
        ])->statePath('data');
    }

    public function handleFileUpload()
    {
        $data = $this->form->getState();
        if (isset($data['file'])) {
            if(pathinfo($data['file'])['extension'] === 'pdf') {
                $text = Pdf::getText(storage_path('app/public').'/'.$data['file']);
                dd($text);

            }
            $this->data['current_file'] = $data['file'];
        }
    }

    public function render()
    {
        return view('livewire.upload-file');
    }

    public function uploadAction(): CreateAction
    {
        return CreateAction::make('upload')->label('Adicionar arquivo')
                           ->model(Music::class)
                           ->form(MusicResource::getFormSchema())
                           ->fillForm(function (array $data) {
                               if ($this->data['current_file']) {
                                   $data['file'] = $this->data['current_file'];
                               }

                               return $data;
                           })->hidden(fn(
            ) => ! isset($this->data['current_file']) || $this->data === [])
                           ->button();
    }
}
