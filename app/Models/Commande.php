<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{


    protected $fillable = ['user_id', 'statut', 'total', 'statut_paiement','burger_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function burgers() {

        return $this->belongsToMany(Burger::class, 'commande_burger')
            ->withPivot('quantite')
            ->withTimestamps();
    }

}
