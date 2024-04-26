<div>
    {{ $this->form }}
    @if($this->uploadAction->isVisible())
        {{ $this->uploadAction }}
    @endif
    <x-filament-actions::modals/>
</div>
