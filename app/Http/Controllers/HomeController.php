<?php

namespace App\Http\Controllers;

use App\Quack;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['home']);
        $this->middleware('guest')->only(['index']);
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
        //$quacks = Quack::with('comments')->latest()->get();
        $quacks = Quack::orderByDesc('created_at')->paginate(10);
        return view('home', ['quacks' => $quacks]);
    }
}
