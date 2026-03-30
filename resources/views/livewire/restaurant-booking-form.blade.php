<div class="relative">
    <!-- Messaggio di Successo con Animazione -->
    @if($message)
        <div class="mb-8 p-6 bg-green-50 border border-green-200 text-green-800 rounded-xl text-center shadow-sm animate-pulse">
            <i class="fa-solid fa-circle-check text-2xl mb-2 block"></i>
            <span class="font-serif italic text-lg">{{ $message }}</span>
        </div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-8">
        <!-- RIGA 1: Data, Turno, Persone -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <label for="booking_date" class="block text-[10px] uppercase tracking-[0.2em] font-bold text-stone-500 mb-3">Data della visita</label>
                <input type="date" id="booking_date" name="booking_date" wire:model="booking_date" 
                    class="w-full border-stone-200 rounded-lg shadow-sm focus:ring-amber-500 focus:border-amber-500 transition-all">
                @error('booking_date') <span class="text-red-600 text-[10px] uppercase mt-1 font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="slot" class="block text-[10px] uppercase tracking-[0.2em] font-bold text-stone-500 mb-3">Turno preferito</label>
                <select id="slot" name="slot" wire:model="slot" 
                    class="w-full border-stone-200 rounded-lg shadow-sm focus:ring-amber-500 focus:border-amber-500 transition-all">
                    <option value="">Seleziona...</option>
                    <option value="pranzo">Pranzo (12:30)</option>
                    <option value="cena">Cena (19:30)</option>
                </select>
                @error('slot') <span class="text-red-600 text-[10px] uppercase mt-1 font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="people_count" class="block text-[10px] uppercase tracking-[0.2em] font-bold text-stone-500 mb-3">Numero Persone</label>
                <input type="number" id="people_count" name="people_count" wire:model="people_count" min="1" max="20"
                    class="w-full border-stone-200 rounded-lg shadow-sm focus:ring-amber-500 focus:border-amber-500 transition-all">
                @error('people_count') <span class="text-red-600 text-[10px] uppercase mt-1 font-bold">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- RIGA 2: Nome ed Email -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label for="customer_name" class="block text-[10px] uppercase tracking-[0.2em] font-bold text-stone-500 mb-3">Nome Completo</label>
                <input type="text" id="customer_name" name="customer_name" wire:model="customer_name" placeholder="es. Mario Rossi" 
                    class="w-full border-stone-200 rounded-lg shadow-sm focus:ring-amber-500 focus:border-amber-500 transition-all placeholder:text-stone-300">
                @error('customer_name') <span class="text-red-600 text-[10px] uppercase mt-1 font-bold">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="customer_email" class="block text-[10px] uppercase tracking-[0.2em] font-bold text-stone-500 mb-3">Indirizzo Email</label>
                <input type="email" id="customer_email" name="customer_email" wire:model="customer_email" placeholder="mario@esempio.it" 
                    class="w-full border-stone-200 rounded-lg shadow-sm focus:ring-amber-500 focus:border-amber-500 transition-all placeholder:text-stone-300">
                @error('customer_email') <span class="text-red-600 text-[10px] uppercase mt-1 font-bold">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Bottone con Stato di Caricamento -->
        <button type="submit" wire:loading.attr="disabled" 
            class="w-full bg-stone-900 text-white py-5 rounded-sm font-bold uppercase tracking-[0.3em] text-xs hover:bg-amber-800 transition-all duration-300 shadow-xl flex items-center justify-center gap-3">
            <span wire:loading.remove>Conferma Prenotazione Tavolo</span>
            <span wire:loading class="flex items-center gap-2">
                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                Elaborazione...
            </span>
        </button>

        <p class="text-center text-[10px] text-stone-400 uppercase tracking-widest italic">
            La prenotazione sarà soggetta a conferma via email
        </p>
    </form>
</div>
