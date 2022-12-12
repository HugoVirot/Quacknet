<?php

namespace App\Http\Controllers;

use App\Models\Quack;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['home']); // seuls les connectés peuvent voir la home
        $this->middleware('guest')->only(['index']); // seuls les invités (non connectés) peuvent voir l'index
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        return view('index');
    }

    public function home()
    {
        // récupère tous les quacks avec leurs commentaires 
        // ('comments' =  dans le modèle Quack, nom de la fonction qui spécifie la relation)

        // user et comments = eager loading  / comments.user = nested eager loading
        $quacks = Quack::with('comments.user')->latest()->paginate(10);

        // on retourne une vue en y injectant les données
        return view('home', compact('quacks'));

        // autre écriture
        //return view('home', ['quacks' => $quacks]);
    }
}
