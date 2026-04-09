<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Models\Commande;

Route::get('/dashboard', function () {
    $stats = [
        'total_commandes' => Commande::count(),
        'en_attente'      => Commande::where('statut', 'en attente')->count(),
        'total_ventes'    => Commande::where('statut', 'livré')->sum('total'),
    ];
    $dernieres_commandes = Commande::with('user')->latest()->take(5)->get();
    return view('dashboard', compact('stats', 'dernieres_commandes'));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {


    Route::get('/', [BurgerController::class, 'index'])->name('burgers.index');
    Route::get('/burger/{id}', [BurgerController::class, 'show'])->name('burgers.show');
    Route::post('/commander', [CommandeController::class, 'store'])->name('commandes.store');
    Route::get('/mes-commandes', [CommandeController::class, 'mesCommandes'])->name('commandes.client');


    Route::put('/commandes/{commande}/{burger}', [CommandeController::class, 'updateQuantite'])->name('commandes.update');
    Route::delete('/commandes/{commande}/{burger}', [CommandeController::class, 'retirerBurger'])->name('commandes.retirer');


    Route::middleware(['auth','admin'])->prefix('admin')->group(function () {

        Route::get('/commandes', [CommandeController::class, 'index'])->name('admin.commandes.index');


        Route::patch('/commandes/{id}/statut', [CommandeController::class, 'updateStatut'])->name('admin.commandes.update');


        Route::patch('/commandes/{commande}/payer', [CommandeController::class, 'payer'])->name('commandes.payer');
        Route::get('/commandes/{commande}/facture', [CommandeController::class, 'genererFacture'])->name('commandes.facture');
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    });

    // --- PROFIL ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
