<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect('/')->with('error', 'Accès refusé !');
        }
        $recettesJour = Commande::whereDate('created_at', today())
            ->where('statut_paiement', 'paye')
            ->sum('total');

        $enAttente = Commande::where('statut', 'en attente')->count();

        // 2. Données pour le graphique (Commandes par mois)
        $commandesParMois = Commande::select(
            DB::raw('count(*) as total'),
            DB::raw('MONTH(created_at) as mois')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('mois')
            ->pluck('total', 'mois')
            ->all();

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $commandesParMois[$i] ?? 0;
        }

        return view('admin.dashboard', compact('recettesJour', 'enAttente', 'chartData'));
    }

}
