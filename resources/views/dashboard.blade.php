<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de Bord - ISI BURGER') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-gray-500 uppercase text-xs">Total Commandes</h3>
                        <p class="text-3xl font-black text-gray-800">{{ $stats['total_commandes'] }}</p>
                    </div>
                    <div class="text-3xl">📦</div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-orange-500 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-gray-500 uppercase text-xs">À Préparer</h3>
                        <p class="text-3xl font-black text-orange-600">{{ $stats['en_attente'] }}</p>
                    </div>
                    <div class="text-3xl">⏳</div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-green-500 flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-bold text-gray-500 uppercase text-xs">Chiffre d'Affaires</h3>
                        <p class="text-3xl font-black text-green-700">{{ number_format($stats['total_ventes'], 0, ',', ' ') }} FCFA</p>
                    </div>
                    <div class="text-3xl">💰</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                        <h3 class="font-bold text-gray-700">Dernières activités</h3>
                        <a href="{{ route('admin.commandes.index') }}" class="text-xs text-blue-600 font-bold hover:underline">Voir tout →</a>
                    </div>
                    <table class="w-full text-left">
                        <thead>
                        <tr class="text-xs uppercase text-gray-400 bg-gray-50">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Client</th>
                            <th class="px-4 py-2">Statut</th>
                            <th class="px-4 py-2 text-right">Montant</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @foreach($dernieres_commandes as $cmd)
                            <tr class="text-sm hover:bg-gray-50">
                                <td class="px-4 py-3 font-bold">#{{ $cmd->id }}</td>
                                <td class="px-4 py-3">{{ $cmd->user->name }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $cmd->statut == 'livré' ? 'bg-green-100 text-green-600' : 'bg-orange-100 text-orange-600' }}">
                                        {{ $cmd->statut }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right font-semibold">{{ number_format($cmd->total, 0) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="bg-gray-800 rounded-xl shadow-lg p-6 text-white">
                    <h3 class="font-bold text-lg mb-4 text-orange-400">Actions Rapides</h3>
                    <div class="space-y-4">
                        <a href="{{ route('admin.commandes.index') }}" class="flex items-center p-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                            <span class="mr-3">📋</span> Gérer les commandes
                        </a>
                        <a href="{{ route('burgers.index') }}" class="flex items-center p-3 bg-gray-700 hover:bg-gray-600 rounded-lg transition">
                            <span class="mr-3">🍔</span> Modifier le Menu
                        </a>
                        <div class="pt-4 border-t border-gray-600 mt-4">
                            <p class="text-xs text-gray-400 italic">Connecté en tant que : <br><strong>{{ Auth::user()->email }}</strong></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
