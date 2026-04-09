
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nos Burgers ISI') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-500 text-white p-4 rounded-lg mb-6 shadow-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($burgers as $burger)
                    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 hover:shadow-2xl transition-shadow">

                        <div class="w-full h-48 mb-4 overflow-hidden rounded-xl bg-gray-100 flex flex-col items-center justify-center">
                            @if($burger->image)
                                <img src="{{ asset('images/' . $burger->image) }}"
                                     alt="{{ $burger->nom }}"
                                     class="w-full h-full object-cover"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">

                                <div style="display:none;" class="text-center p-2">
                                    <span class="text-red-500 text-xs font-bold">Fichier introuvable :</span><br>
                                    <span class="text-gray-700 text-xs">public/images/{{ $burger->image }}</span>
                                </div>
                            @else
                                <span class="text-orange-500 text-xs font-bold">ERREUR : Colonne 'image' vide en base !</span>
                            @endif
                        </div>

                        <h2 class="text-2xl font-black text-gray-800">{{ $burger->nom }}</h2>
                        <p class="text-gray-500 text-sm mt-2 leading-relaxed h-12 overflow-hidden">
                            {{ $burger->description }}
                        </p>

                        <div class="flex justify-between items-center mt-6">
                            <span class="text-blue-600 font-black text-lg">{{ number_format($burger->prix, 0, ',', ' ') }} FCFA</span>

                            <form action="{{ route('commandes.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="burger_id" value="{{ $burger->id }}">
                                <p class="text-red-500 font-bold text-xs mb-1">  Stock = {{ $burger->stock }}</p>
                                @if($burger->stock > 0)
                                    <button type="submit"
                                            class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-xl font-bold shadow-lg transition-transform active:scale-95">
                                        Commander
                                    </button>
                                @else
                                    <button type="button"
                                            disabled
                                            class="bg-gray-300 text-gray-500 px-4 py-2 rounded-xl font-bold cursor-not-allowed shadow-none border border-gray-200">
                                        Rupture ❌
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
