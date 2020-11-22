<?php

namespace App\Http\Controllers\User;

use Auth;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()            //affiche page avec les infos du compte
    {
        $user = Auth::user();

        return view('user.account', ['user' => $user]);
    }

    public function edit(){
        $user = Auth::user();

        return view('user.accountupdatepage', ['user' => $user]);
    }

    public function update(Request $request)      //permet de valider les modifs
    {
        $request->validate([     //method not found : ignorer, marche quand même (idem digidog)
            'prenom' => 'required|max:50',
            'nom' => 'required|max:50',
            'password' => 'present',     //erreur si mdp identique à l'ancien
        ]);

        $user = Auth::user();        //on récupère les données de base de l'utilisateur
        $user->prenom = $request->input('prenom');         //on insère ainsi les nouvelles données
        $user->nom = $request->input('nom');

        if ($request->input('password') !== null) {                                    //si on a rentré un nouveau mdp
            $request->validate(['password' => 'min:8|confirmed']);  //on le teste (si pas bon => erreur)
            $oldpassword = $user->password;
            $newpassword = $request->input('password');

            if (Hash::check($newpassword, $oldpassword)) {
                return redirect()->route('user.account.updatepage')->withErrors(['password_error', 'ancien et nouveau mot de passe identiques !']);
            } else {
                $user->password = Hash::make($newpassword);                //si ok, on le sauvegarde en bdd
            }
        }

        $user->save();

        return redirect()->route('user.account');
    }

    public function profil(User $user)
    {
        $user->load('quacks.comments.user');

        return view('user.profil', ['user' => $user]);
    }
}
