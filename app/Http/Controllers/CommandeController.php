<?php
namespace App\Http\Controllers;
use App\Models\Commande;
use App\Models\Burger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\FactureMail;


class CommandeController extends Controller
{


    public function mesCommandes()
    {

        $commandes = Commande::with('burgers')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        return view('commandes.client', compact('commandes'));
    }


    public function index()
    {
        $commandes = Commande::with(['burgers', 'user'])->latest()->get();
        $totalVentes = Commande::where('statut', 'livré')->get()->sum(function($commande) {
            return $commande->burgers->sum(function($burger) {
                return $burger->prix * $burger->pivot->quantite;
            });
        });

        $recettesJour = Commande::where('statut_paiement', 'paye')
            ->whereDate('updated_at', now())
            ->sum('total');

        $enAttente = Commande::where('statut', 'en attente')->count();

        $commandesParMois = Commande::selectRaw('MONTH(created_at) as mois, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('mois')
            ->pluck('total', 'mois')
            ->all();

        $chartData = [];
        for($i = 1; $i <= 12; $i++) {

            $chartData[] = $commandesParMois[$i] ?? 0;
        }
        return view('admin.commandes.index', compact(
            'commandes',
            'totalVentes',
            'recettesJour',
            'enAttente',
            'chartData'
        ));
    }

    public function store(Request $request)
    {
        $burger = Burger::findOrFail($request->burger_id);
        $quantite = $request->input('quantite', 1);
        $commande = Commande::create([
            'user_id' => auth()->id(),
            'statut'  => 'en attente'],
            ['total'   => 0]
        );
        $existing = $commande->burgers()->where('burger_id', $burger->id)->first();

        if ($existing) {
            $nouvelleQuantite = $existing->pivot->quantite + $quantite;
            $commande->burgers()->updateExistingPivot($burger->id, [
                'quantite' => $nouvelleQuantite
            ]);
        } else {
            $commande->burgers()->attach($burger->id, ['quantite' => $quantite]);
        }

        $this->recalculerTotal($commande);

        return back()->with('success', 'Burger ajouté au panier !');

    }
    private function recalculerTotal($commande)
    {
        $nouveauTotal = $commande->burgers->sum(function ($burger) {
            return $burger->prix * $burger->pivot->quantite;
        });

        $commande->update(['total' => $nouveauTotal]);
    }
    public function update(Request $request, $commandeId, $burgerId)
    {
        $commande = Commande::findOrFail($commandeId);

        $commande->burgers()->updateExistingPivot($burgerId, [
            'quantite' => $request->quantite
        ]);
        $nouveauTotal = $commande->burgers->sum(function ($burger) {
            return $burger->prix * $burger->pivot->quantite;
        });
        $commande->update(['total' => $nouveauTotal]);
        return back()->with('success', 'Le total de la commande a été mis à jour : ' . number_format($nouveauTotal, 0, ',', ' ') . ' FCFA');

    }
    public function updateStatut(Request $request, $id)
    {
        $commande = Commande::findOrFail($id);
        $request->validate(['statut' => 'required|string']);
        $commande->update(['statut' => $request->statut]);

        return back()->with('success', 'Le statut de la commande #' . $id . ' a été mis à jour.');
    }
    public function updateQuantite(Request $request, $commandeId, $burgerId)
    {
        $commande = Commande::findOrFail($commandeId);
        $commande->burgers()->updateExistingPivot($burgerId, [
            'quantite' => $request->quantite
        ]);
        $this->recalculerTotal($commande);

        return back()->with('success', 'Quantité mise à jour !');
    }
    public function retirerBurger($commandeId, $burgerId)
    {
        $commande = Commande::findOrFail($commandeId);
        $commande->burgers()->detach($burgerId); // Supprime la liaison

        // Optionnel : Si plus aucun burger, on supprime la commande
        if ($commande->burgers()->count() == 0) {
            $commande->delete();
        }

        return back()->with('success', 'Article retiré de la commande.');
    }
    public function payer(Commande $commande)
   {
       $commande->update([
          'statut_paiement' => 'paye',
    ] );
       return back()->with('success', 'Paiement encaissé ! La facture est maintenant disponible.');
   }
    public function genererFacture(Commande $commande)
    {
        $commande->load(['user', 'burgers']);

        $pdf = Pdf::loadView('admin.commandes.facture', compact('commande'));

        return $pdf->download('facture-isiburger-'.$commande->id.'.pdf');
    }


}
