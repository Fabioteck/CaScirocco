<x-filament-panels::page>
    <!-- Fila 1: I 4 Grafici a Torta -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @livewire(\App\Filament\Widgets\StatsGiornoChart::class)
        @livewire(\App\Filament\Widgets\StatsSettimanaChart::class)

    </div>

    <!-- Fila 2: Andamento (I grafici vettoriali che avevi già) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
        @livewire(\App\Filament\Widgets\BookingChart::class)
        @livewire(\App\Filament\Widgets\StatsPieChart::class)
    </div>
</x-filament-panels::page>
