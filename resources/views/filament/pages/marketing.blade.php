<x-filament-panels::page>
    <x-filament::section>
        <div class="flex flex-col items-center justify-center p-8 text-center">
            <h2 class="text-2xl font-bold mb-4 text-stone-800">QR Code Menù Digitale</h2>
            <p class="text-stone-500 mb-8 max-w-md">Inquadra questo codice per accedere istantaneamente al menù di oggi di Cà Scirocco.</p>
            
            <div class="bg-white p-6 rounded-3xl shadow-xl border border-stone-100">
                {!! $this->getQrCode() !!}
            </div>

            <div class="mt-10 flex gap-4">
                <x-filament::button icon="heroicon-o-printer" onclick="window.print()">
                    Stampa Codice
                </x-filament::button>
            </div>
        </div>
    </x-filament::section>
</x-filament-panels::page>
