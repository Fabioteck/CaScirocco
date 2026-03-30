<div class="bg-white min-h-screen py-12 px-6">
    <div class="max-w-2xl mx-auto">
        
        <!-- Header in stile Menu Digitale -->
        <div class="text-center mb-20">
            <h2 class="text-3xl font-serif italic text-stone-800 tracking-tight">La Nostra Cantina</h2>
            <div class="w-12 h-px bg-stone-200 mx-auto mt-6"></div>
        </div>

        @foreach($collezioneVini as $tipologia => $vini)
            <div class="mb-16">
                <!-- Titolo Categoria: Piccolo, Rosso/Arancio, molto spaziato -->
                <h3 class="text-[10px] text-center uppercase tracking-[0.4em] text-red-800 font-bold mb-12">
                    {{ $tipologia }}
                </h3>

                <div class="space-y-8">
                    @foreach($vini as $vino)
                        <div class="border-b border-stone-100 pb-4">
                            <div class="flex justify-between items-baseline">
                                <div class="flex-1 pr-4">
                                    <!-- Nome Vino -->
                                    <h4 class="text-base font-bold text-stone-900 leading-tight">
                                        {{ $vino->name }}
                                    </h4>
                                    <!-- Dettagli: Grigio chiaro, minuscolo -->
                                    <p class="text-[10px] text-stone-400 uppercase tracking-widest mt-1">
                                        {{ $vino->producer }} · {{ $vino->region }} ({{ $vino->vintage }})
                                    </p>
                                </div>
                                <!-- Prezzo: Pulito a destra -->
                                <div class="text-base font-bold text-stone-900 whitespace-nowrap">
                                    {{ number_format($vino->price_bottle, 2, '.', '') }}€
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Bottone Back (Più discreto sotto o fisso) -->
        <div class="mt-20 text-center">
            <a href="{{ url('/') }}" class="text-[10px] uppercase tracking-[0.2em] text-stone-400 hover:text-orange-500 transition-colors">
                ← Torna Indietro
            </a>
        </div>
         <!--  Bottone menu -->
        <div class="mt-20 text-center border-t border-stone-100 pt-10">
            <p class="text-stone-400 text-sm mb-4">Vuoi vedere i nostri piatti</p>
            <a href="{{ url('menu-digital') }}" 
            class="inline-block px-8 py-3 bg-stone-900 text-white text-xs uppercase tracking-widest font-bold rounded-full hover:bg-orange-900 transition shadow-xl">
                Consulta Menu del giorno
            </a>
         <!--  Bottone menu -->
            <p class="text-stone-400 text-sm mb-4">Vuoi vedere i nostri piatti</p>
            <a href="{{ url('il-menu') }}" 
            class="inline-block px-8 py-3 bg-stone-900 text-white text-xs uppercase tracking-widest font-bold rounded-full hover:bg-orange-900 transition shadow-xl">
                Consulta Menu Stagionale
            </a>
        </div>


</br>
    </div>
</div>
