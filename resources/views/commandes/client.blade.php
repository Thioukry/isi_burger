<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Commandes - ISI BURGER</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Gestion de mes commandes</h1>
        <a href="{{ route('burgers.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            ← Retour au Menu
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg mb-6 shadow-md">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-8">
        @forelse($commandes as $commande)
            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200">
                <div class="bg-gray-800 text-white p-4 flex justify-between items-center">
                    <div>
                        <span class="font-bold text-lg">Commande #{{ $commande->id }}</span>
                        <span class="ml-4 text-gray-400 text-sm">{{ $commande->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex items-center gap-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-500 text-white uppercase">
                                {{ $commande->statut }}
                            </span>
                        <span class="text-xl font-bold text-orange-400">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>

                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Produit</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase text-center">Quantité</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase text-right">Actions</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                    @foreach($commande->burgers as $burger)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <div class="font-semibold text-gray-700">🍔 {{ $burger->nom }}</div>
                                    <div class="text-xs text-gray-500 italic mt-1">
                                        {{ $burger->pivot->quantite }} x {{ number_format($burger->prix, 0, ',', ' ') }} FCFA
                                        = <span class="font-bold text-orange-600">
                                            {{ number_format($burger->prix * $burger->pivot->quantite, 0, ',', ' ') }} FCFA
                                          </span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('commandes.update', [$commande->id, $burger->id]) }}" method="POST" class="flex items-center justify-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantite" value="{{ $burger->pivot->quantite }}" min="1"
                                           class="w-16 border border-gray-300 rounded-md p-1 text-center focus:ring-2 focus:ring-blue-500 outline-none">
                                    <button type="submit" class="bg-blue-100 text-blue-600 px-3 py-1 rounded-md text-sm font-bold hover:bg-blue-200 transition">
                                        Mettre à jour
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('commandes.retirer', [$commande->id, $burger->id]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Voulez-vous retirer ce burger de la commande ?')"
                                            class="text-red-500 hover:text-red-700 font-bold text-sm underline px-2 py-1">
                                        Retirer l'article
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @empty
            <div class="bg-white p-12 text-center rounded-xl shadow-sm border border-dashed border-gray-300">
                <p class="text-gray-500 text-lg">Vous n'avez pas encore passé de commande.</p>
                <a href="{{ route('burgers.index') }}" class="mt-4 inline-block text-blue-600 font-bold hover:underline">Voir le menu des burgers</a>
            </div>
        @endforelse
    </div>
</div>
</body>
</html>
