<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold mb-10 text-center">Galleria Ca' Scirocco</h1>

    @foreach($categories as $category)
        <section class="mb-16">
            <h2 class="text-2xl font-semibold mb-6 border-b-2 border-orange-500 inline-block">
                {{ $category->name }}
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($category->galleries as $photo)
                    <div class="group relative overflow-hidden rounded-xl shadow-lg bg-gray-200">
                        <img src="{{ asset('storage/' . $photo->image_path) }}" 
                             alt="{{ $photo->title }}" 
                             class="w-full h-64 object-cover transition duration-500 group-hover:scale-110">
                        
                        @if($photo->title)
                            <div class="absolute bottom-0 left-0 right-0 bg-black/50 p-2 text-white text-sm">
                                {{ $photo->title }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach
</div>
