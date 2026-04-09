<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Burger extends Model
{

    protected $fillable = ['nom', 'prix', 'image', 'description', 'stock', 'is_archived'];

    public function commande() {
        return $this->belongsToMany(Commande::class)->withPivot('quantite');
    }
  //  public function commandes()
    //{
      //  return $this->hasMany(Commande::class);
    //}

}
