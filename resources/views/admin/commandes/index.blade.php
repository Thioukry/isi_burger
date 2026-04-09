<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Gestion des Commandes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- AJOUT DE CHART.JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="p-8 max-w-7xl mx-auto">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-10 bg-white p-6 rounded-2xl shadow-lg border-b-4 border-orange-500">
        <div class="flex items-center gap-6">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 bg-gray-900 hover:bg-black text-white px-6 py-3 rounded-xl transition-all shadow-xl hover:scale-105 active:scale-95">
                <span class="text-xl">🏠</span>
                <span class="font-black uppercase tracking-widest text-sm">Tableau de Bord</span>
            </a>
            <div class="h-10 w-px bg-gray-200 hidden md:block"></div>
            <h1 class="text-2xl font-black text-gray-800 tracking-tighter">GESTION COMMANDES</h1>
        </div>

        <div class="mt-4 md:mt-0">
            <a href="{{ route('burgers.index') }}" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-bold shadow-lg transition-all hover:-translate-y-1">
                <span>🍔</span> Gérer le Menu
            </a>
        </div>
    </div>

    {{-- STATISTIQUES --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-8 border-emerald-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs text-gray-500 font-black uppercase tracking-widest mb-1">Recettes du Jour</p>
                    <h3 class="text-3xl font-black text-gray-800">
                        {{ number_format($recettesJour, 0, ',', ' ') }} <span class="text-sm font-normal text-gray-400">FCFA</span>
                    </h3>
                </div>
                <div class="bg-emerald-100 p-3 rounded-full text-3xl">💰</div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-8 border-orange-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs text-gray-500 font-black uppercase tracking-widest mb-1">À préparer</p>
                    <h3 class="text-3xl font-black text-gray-800">
                        {{ $enAttente }} <span class="text-sm font-normal text-gray-400">Commandes</span>
                    </h3>
                </div>
                <div class="bg-orange-100 p-3 rounded-full text-3xl">👨‍🍳</div>
            </div>
        </div>
    </div>

    {{-- NOUVEAU : SECTION GRAPHIQUE --}}
    <div class="bg-white p-6 rounded-2xl shadow-lg mb-8 border border-gray-100">
        <div class="flex items-center gap-2 mb-6">
            <span class="text-xl">📈</span>
            <h3 class="text-sm font-black text-gray-700 uppercase tracking-wider">Évolution des Commandes ({{ date('Y') }})</h3>
        </div>
        <div class="h-[250px] w-full">
            <canvas id="myChart"></canvas>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-8 shadow-sm">
            <p class="font-bold">Succès !</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- TABLEAU --}}
    <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
        <table class="w-full text-left border-collapse">
            <thead>
            <tr class="bg-gray-800 text-white text-xs uppercase tracking-widest">
                <th class="p-5 text-center">ID</th>
                <th class="p-5">Date & Heure</th>
                <th class="p-5">Client</th>
                <th class="p-5">Composition</th>
                <th class="p-5 text-center">Total</th>
                <th class="p-5 text-center">Statut</th>
                <th class="p-5 text-center">Paiement</th>
                <th class="p-5 text-right">Mise à jour</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            @forelse($commandes as $commande)
                <tr class="hover:bg-orange-50/50 transition-colors">
                    <td class="p-5 font-black text-blue-600 text-center text-lg">#{{ $commande->id }}</td>
                    <td class="p-5 text-sm text-gray-500">
                        <span class="font-bold text-gray-700">{{ $commande->created_at->format('d/m/Y') }}</span><br>
                        <span class="text-xs italic">{{ $commande->created_at->format('H:i') }}</span>
                    </td>
                    <td class="p-5">
                        <div class="font-bold text-gray-800">{{ $commande->user->name }}</div>
                        <div class="text-xs text-blue-500">{{ $commande->user->email }}</div>
                    </td>
                    <td class="p-5">
                        @foreach($commande->burgers as $burger)
                            <span class="inline-flex items-center bg-white border border-gray-200 text-gray-700 px-2 py-1 rounded-md text-[11px] font-bold mb-1 mr-1 shadow-sm">
                                <span class="text-orange-500 mr-1">{{ $burger->pivot->quantite }}x</span> {{ $burger->nom }}
                            </span>
                        @endforeach
                    </td>
                    <td class="p-5 font-black text-center text-gray-900 text-lg">
                        {{ number_format($commande->total, 0, ',', ' ') }} <span class="text-[10px] font-normal">FCFA</span>
                    </td>
                    <td class="p-5 text-center">
                        @php
                            $color = match($commande->statut) {
                                'en attente' => 'bg-orange-100 text-orange-600 border-orange-200',
                                'en cours'   => 'bg-blue-100 text-blue-600 border-blue-200',
                                'livré'      => 'bg-green-100 text-green-600 border-green-200',
                                'annulé'     => 'bg-red-100 text-red-600 border-red-200',
                                default      => 'bg-gray-100 text-gray-600',
                            };
                        @endphp
                        <span class="px-4 py-1 rounded-full text-[10px] font-black uppercase border shadow-sm {{ $color }}">
                            {{ $commande->statut }}
                        </span>
                    </td>

                    <td class="p-5 text-center">
                        @if($commande->statut_paiement == 'paye')
                            <div class="flex flex-col items-center gap-2">
                                <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-black uppercase border border-green-200 shadow-sm">
                                    ✅ PAYÉ
                                </span>
                                <a href="{{ route('commandes.facture', $commande->id) }}" class="flex items-center gap-1 text-blue-600 hover:text-blue-800 text-[10px] font-black uppercase tracking-tighter transition-all hover:underline">
                                    📄 Facture PDF
                                </a>
                            </div>
                        @elseif($commande->statut == 'livré')
                            <form action="{{ route('commandes.payer', $commande->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white font-black py-2 px-4 rounded-xl text-[10px] uppercase shadow-lg transition-all active:scale-95">
                                    Encaisser 💰
                                </button>
                            </form>
                        @elseif($commande->statut == 'annulé')
                            <span class="text-red-400 text-[10px] font-bold uppercase italic">❌ Annulée</span>
                        @else
                            <div class="flex flex-col items-center gap-1">
                                <div class="flex gap-1">
                                    <span class="w-1.5 h-1.5 bg-orange-400 rounded-full animate-pulse"></span>
                                    <span class="w-1.5 h-1.5 bg-orange-400 rounded-full animate-pulse [animation-delay:0.2s]"></span>
                                    <span class="w-1.5 h-1.5 bg-orange-400 rounded-full animate-pulse [animation-delay:0.4s]"></span>
                                </div>
                                <span class="text-gray-400 text-[9px] font-black uppercase tracking-widest">En cuisine...</span>
                            </div>
                        @endif
                    </td>

                    <td class="p-5 text-right">
                        <form action="{{ route('admin.commandes.update', $commande->id) }}" method="POST" class="flex items-center justify-end gap-2">
                            @csrf
                            @method('PATCH')
                            <select name="statut" class="border-2 border-gray-100 rounded-xl p-2 text-xs font-bold outline-none focus:border-blue-400 bg-gray-50 transition-all">
                                <option value="en attente" {{ $commande->statut == 'en attente' ? 'selected' : '' }}>En attente</option>
                                <option value="en cours" {{ $commande->statut == 'en cours' ? 'selected' : '' }}>En cours</option>
                                <option value="livré" {{ $commande->statut == 'livré' ? 'selected' : '' }}>Livré</option>
                                <option value="annulé" {{ $commande->statut == 'annulé' ? 'selected' : '' }}>Annulé</option>
                            </select>
                            <button type="submit" class="bg-gray-800 hover:bg-black text-white font-bold py-2 px-4 rounded-xl text-[10px] uppercase shadow-md transition-all active:scale-90">
                                OK
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="p-20 text-center">
                        <div class="text-5xl mb-4">📭</div>
                        <p class="text-gray-400 italic text-xl font-light">Aucune commande pour le moment...</p>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- SCRIPT DU GRAPHIQUE --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Déc'],
                datasets: [{
                    label: 'Nombre de commandes',
                    data: @json($chartData),
                    borderColor: '#f97316',
                    backgroundColor: 'rgba(249, 115, 22, 0.1)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#f97316'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 },
                        grid: { borderDash: [5, 5] }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>

</body>
</html>
