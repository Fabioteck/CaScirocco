<x-filament-widgets::widget>
    <form wire:submit.prevent="save">
        {{ $this->form }}

        <div class="mt-2 text-right">
            <x-filament::button type="submit" color="warning" size="sm">
                Aggiorna Chiusura
            </x-filament::button>
        </div>
    </form>
</x-filament-widgets::widget>
