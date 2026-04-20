<x-filament-panels::page>
    <div class="flex flex-col gap-4">
        
        {{-- TOOLBAR SUPERIORE --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white dark:bg-gray-900 p-4 rounded-xl shadow-sm border dark:border-gray-800">
            <div class="flex gap-2">
                <x-filament::button wire:click="loadEmails" icon="heroicon-m-arrow-path" color="warning" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="loadEmails">Sincronizza</span>
                    <span wire:loading wire:target="loadEmails">Caricamento...</span>
                </x-filament::button>

                {{-- TASTO NUOVA EMAIL --}}
                <x-filament::button wire:click="composeEmail" icon="heroicon-m-plus" color="success">
                    Nuova Email
                </x-filament::button>
            </div>

            <div class="flex items-center gap-3">
                <x-filament::icon-button icon="heroicon-m-chevron-left" wire:click="prevPage" :disabled="$currentPage == 1" color="gray" label="Precedente" />
                <span class="text-sm font-bold bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-md text-gray-600 dark:text-gray-300">Pagina {{ $currentPage }}</span>
                <x-filament::icon-button icon="heroicon-m-chevron-right" wire:click="nextPage" :disabled="($currentPage * $perPage) >= $totalEmails" color="gray" label="Successiva" />
            </div>
        </div>

        {{-- TABELLA EMAIL --}}
        <div class="overflow-hidden bg-white shadow-sm rounded-xl ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <table class="w-full text-left divide-y divide-gray-200 dark:divide-white/5">
                <thead class="bg-gray-50 dark:bg-white/5">
                    <tr>
                        <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase w-10">Stato</th>
                        <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase">Oggetto</th>
                        <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase">Da</th>
                        <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase">Data</th>
                        <th class="px-4 py-3 text-xs font-bold text-gray-500 uppercase text-right">Azioni</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                    @forelse($emails as $email)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                            <td class="px-4 py-3">
                                @if($email['is_unread'])
                                    <div class="h-2.5 w-2.5 rounded-full bg-primary-600 shadow-[0_0_8px_rgba(var(--primary-600),0.5)]" title="Non letto"></div>
                                @else
                                    <div class="h-2.5 w-2.5 rounded-full bg-gray-300 dark:bg-gray-600" title="Letto"></div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <button wire:click="openEmail({{ $email['uid'] }})" 
                                    class="text-left hover:underline {{ $email['is_unread'] ? 'font-bold text-gray-900 dark:text-white' : 'text-gray-600 dark:text-gray-400' }}">
                                    {{ $email['subject'] }}
                                </button>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400 font-medium">{{ $email['from'] }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $email['date'] }}</td>
                            <td class="px-4 py-3 text-sm text-right space-x-1">
                                <x-filament::icon-button icon="heroicon-m-eye" color="info" wire:click="openEmail({{ $email['uid'] }})" size="sm" />
                                <x-filament::icon-button icon="heroicon-m-trash" color="danger" wire:click="deleteEmail({{ $email['uid'] }})" wire:confirm="Eliminare definitivamente?" size="sm" />
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-10 text-center text-gray-400 italic">Nessun messaggio trovato.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINAZIONE INFERIORE --}}
        <div class="flex items-center justify-between p-4 bg-white dark:bg-gray-900 rounded-xl border dark:border-gray-800 shadow-sm">
            <span class="text-xs text-gray-400 font-medium uppercase tracking-tighter">Totale: {{ $totalEmails }}</span>
            <div class="flex items-center gap-2">
                <x-filament::button wire:click="prevPage" :disabled="$currentPage == 1" color="gray" size="sm" variant="outline">Indietro</x-filament::button>
                <x-filament::button wire:click="nextPage" :disabled="($currentPage * $perPage) >= $totalEmails" color="gray" size="sm" variant="outline">Avanti</x-filament::button>
            </div>
        </div>
    </div>

    {{-- MODAL UNIFICATO (LETTURA / RISPOSTA / NUOVA) --}}
    <x-filament::modal id="view-email" width="5xl">
        <x-slot name="header">
            <h2 class="text-xl font-bold">{{ $selectedEmail ? 'Leggi / Rispondi' : 'Nuovo Messaggio' }}</h2>
        </x-slot>

        <div class="space-y-4">
            @if($selectedEmail)
                {{-- VISUALIZZAZIONE EMAIL RICEVUTA --}}
                <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border dark:border-gray-700 max-h-60 overflow-y-auto">
                    <div class="mb-2 text-xs font-bold uppercase text-gray-400">Oggetto: {{ $selectedEmail['subject'] }}</div>
                    <div class="prose dark:prose-invert max-w-none text-sm">
                        {!! $selectedEmail['body'] !!}
                    </div>
                </div>
            @else
                {{-- CAMPI PER NUOVA EMAIL --}}
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">A (Destinatario):</label>
                        <input type="email" wire:model="toEmail" class="w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-700 focus:ring-primary-500" placeholder="cliente@esempio.it">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Oggetto:</label>
                        <input type="text" wire:model="subject" class="w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-700 focus:ring-primary-500" placeholder="Oggetto del messaggio">
                    </div>
                </div>
            @endif

            <hr class="dark:border-gray-700">

            {{-- AREA SCRITTURA MESSAGGIO --}}
            <div class="space-y-3">
                <h3 class="text-lg font-bold">{{ $selectedEmail ? 'Risposta' : 'Corpo del messaggio' }}</h3>
                <textarea wire:model="replyBody" class="w-full rounded-lg border-gray-300 dark:bg-gray-900 dark:border-gray-700 focus:ring-primary-500" rows="6" placeholder="Scrivi qui il tuo messaggio..."></textarea>
                
                <div class="bg-gray-50 dark:bg-gray-800 p-3 rounded-lg border border-dashed border-gray-300 dark:border-gray-700">
                    <label class="block text-sm font-medium mb-2 text-gray-600 dark:text-gray-400">Allegati (Max 50MB):</label>
                    <input type="file" wire:model="attachments" multiple class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                    <div wire:loading wire:target="attachments" class="text-xs text-primary-600 mt-1 italic">Caricamento file in corso...</div>
                </div>

                <div class="flex justify-end pt-2">
                    <x-filament::button wire:click="sendReply" color="primary" icon="heroicon-m-paper-airplane" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="sendReply">Invia Email</span>
                        <span wire:loading wire:target="sendReply">Invio in corso...</span>
                    </x-filament::button>
                </div>
            </div>
        </div>
    </x-filament::modal>
</x-filament-panels::page>
