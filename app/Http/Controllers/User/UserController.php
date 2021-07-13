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

    public function edit()
    {
        $user = Auth::user();
        return view('user.accountupdatepage', ['user' => $user]);
    }

    public function update(Request $request)      //permet de valider les modifs
    {
        $request->validate([
            'prenom' => 'required|min:3|max:50',
            'nom' => 'required|min:3|max:50',
        ]);

        $user = Auth::user();                              //on récupère les données de base de l'utilisateur
        $user->prenom = $request->input('prenom');         //on insère ainsi les nouvelles données
        $user->nom = $request->input('nom');
        $user->image = $request->input('image');

        if ($request->input('password') !== null) {                 $//si on a rentré un nouveau mdp
            $request->validate([  //on le teste (si pas bon => erreur)
                'password' => [
                    'required',
                    'confirmed',
                    'min:8',
                    'regex:/^(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[!$#%@]).*$/'
                ]
            ]);

            $oldpassword = $user->password;
            $newpassword = $request->input('password');

            if (Hash::check($newpassword, $oldpassword)) {          //si nouveau et ancien mdp identiques => erreur
                return redirect()->route('user.account.edit')->withErrors(['password_error', 'ancien et nouveau mot de passe identiques !']);
            } else {
                $user->password = Hash::make($newpassword);                //si ok, on le sauvegarde en bdd
            }
        }

        $user->save();

        return redirect()->route('user.account')->with('message', 'Le compte a bien été modifié');
    }

    public function profil(User $user)
    {
        // $user->load('quacks.comments.user');
        $user->load('quacks');
        return view('user.profil', compact('user'));
    }

    public function destroy(User $user)
    {
        if (Auth::user()->id == $user->id) {
            $user->delete();
            return redirect()->route('index')->with('message', 'Le compte a bien été supprimé');
        } else {
            return redirect()->back()->withErrors(['erreur' => 'suppression du compte impossible']);
        }
    }
}
