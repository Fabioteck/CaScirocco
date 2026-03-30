<div class="bg-[#fcfbf7] min-h-screen py-16 px-6 font-sans">
    <div class="max-w-2xl mx-auto">
        
        <!-- Header Titolo (Stile Ca' Scirocco) -->
        <div class="text-center mb-20">
            <h1 class="text-4xl font-serif italic text-stone-800 tracking-tight">Menù Stagionale</h1>
            <div class="mt-4 flex justify-center items-center gap-3">
                <span class="h-[1px] w-8 bg-orange-300"></span>
                <p class="text-stone-500 uppercase tracking-[0.2em] text-[10px]">Dalla Terra alla Tavola</p>
                <span class="h-[1px] w-8 bg-orange-300"></span>
            </div>
        </div>

        @foreach($dishes as $nomeCategoria => $piatti)
            <!-- SEZIONE CATEGORIA -->
            <div class="mb-16">
                <!-- Titolo Categoria con Linea sottile -->
                <div class="flex items-center gap-4 mb-10">
                    <h2 class="text-2xl text-stone-800 italic font-serif whitespace-nowrap">{{ $nomeCategoria }}</h2>
                    <div class="flex-grow h-[1px] bg-stone-200"></div>
                </div>

                <div class="space-y-12">
                    @foreach($piatti as $piatto)
                        <!-- SINGOLO PIATTO -->
                        <div class="group">
                            <div class="flex justify-between items-baseline gap-2 mb-1">
                                {{-- Nome Piatto con maiuscole eleganti --}}
                                <h3 class="text-base font-bold text-stone-900 leading-tight uppercase tracking-tight group-hover:text-orange-900 transition-colors">
                                    {{ $piatto->name }}
                                </h3>
                                
                                {{-- Linea Tratteggiata Dinamica --}}
                                <div class="flex-grow border-b border-dotted border-stone-300 h-1 mb-1"></div>
                                
                                {{-- Prezzo --}}
                                <div class="text-base font-bold text-stone-900 whitespace-nowrap">
                                    {{ number_format($piatto->price, 2, ',', '.') }}€
                                </div>
                            </div>

                            {{-- Descrizione Ingredienti --}}
                            @if($piatto->description)
                                <p class="text-[13px] text-stone-500 italic leading-relaxed pr-12">
                                    {{ $piatto->description }}
                                </p>
                            @endif

                            {{-- Allergeni (Piccoli sotto) --}}
                            @if($piatto->allergens)
                                <p class="text-[9px] text-stone-400 uppercase tracking-tighter mt-1">
                                    Allergeni: {{ $piatto->allergens }}
                                </p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Footer / Torna Indietro -->
        <div class="mt-24 text-center border-t border-stone-100 pt-10 pb-20">
            <a href="{{ url('/') }}" class="inline-block px-8 py-3 bg-stone-900 text-white text-[10px] uppercase tracking-[0.2em] font-bold rounded-full hover:bg-orange-900 transition shadow-lg">
                ← Torna alla Home
            </a>
        </div>
    </div>
</div>
