<?php

namespace App\Http\Controllers;
use App\Models\Burger;

use Illuminate\Http\Request;

class BurgerController extends Controller
{
    public function index()
    {
        $burgers = Burger::where('is_archived', false)->get();
        return view('burgers.index', compact('burgers'));

    }


    public function show($id)
    {
        $burger = Burger::findOrFail($id);
        return view('burgers.show', compact('burger'));
    }
}

