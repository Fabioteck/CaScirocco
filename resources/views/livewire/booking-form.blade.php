<div>
    <form wire:submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
        @if($message)
            <div class="p-4 mb-4 text-white bg-amber-700 rounded-lg">{{ $message }}</div>
        @endif
    </div>

    <div class="flex flex-col">
        <label class="text-sm font-bold text-stone-600">Scegli la Stanza</label>
        <select wire:model="room_id" class="border p-2 rounded bg-stone-50">
            <option value="">Seleziona...</option>
            @foreach($rooms as $room)
                <option value="{{ $room->id }}">{{ $room->name }} ({{ $room->capacity }} posti)</option>
            @endforeach
        </select>
    </div>

    <div class="flex flex-col">
        <label class="text-sm font-bold text-stone-600">Il Tuo Nome</label>
        <input type="text" wire:model="customer_name" class="border p-2 rounded" placeholder="Mario Rossi">
    </div>

    <div class="flex flex-col">
        <label class="text-sm font-bold text-stone-600">Email</label>
        <input type="email" wire:model="customer_email" class="border p-2 rounded" placeholder="mario@esempio.it">
    </div>

    <div class="flex flex-col">
        <label class="text-sm font-bold text-stone-600">Check-in</label>
        <input type="date" wire:model="check_in" class="border p-2 rounded">
    </div>

    <div class="flex flex-col">
        <label class="text-sm font-bold text-stone-600">Check-out</label>
        <input type="date" wire:model="check_out" class="border p-2 rounded">
    </div>

    <div class="md:col-span-2 mt-4 text-center">
        <button type="submit" class="bg-stone-900 text-white px-12 py-3 rounded-full hover:bg-stone-700 transition">
            Invia Richiesta di Prenotazione
        </button>
    </div>
</form>

</div>
