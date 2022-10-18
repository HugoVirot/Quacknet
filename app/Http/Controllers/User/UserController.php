<?php

namespace App\Http\Controllers\User;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Quack;

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
        return view('user.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)      //permet de valider les modifs
    {
        $request->validate([
            'prenom' => 'required|min:3|max:50',
            'nom' => 'required|min:3|max:50',
        ]);

        $user = Auth::user();                              //on récupère les données de base de l'utilisateur
        
        $user->prenom = $request->input('prenom');         //on modifie les infos de l'utilisateur
        $user->nom = $request->input('nom');
        $user->image = $request->input('image');

        $user->save();                                      //on insère ainsi les nouvelles données

        //$user->update($request->all());  // syntaxe optimisée

        return redirect()->route('user.account')->with('message', 'Le compte a bien été modifié');
    }


    public function updatePassword(Request $request)      //permet de valider les modifs
    {
        $request->validate([
            'password' => 'required',
            'newPassword' => [
                'required', 'confirmed', 'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!$#%@]).*$/'
                // nouvelle syntaxe (laravel 8 uniquement)
                // Password::min(8) // minimum 8 caractères
                //     ->mixedCase() // Require at least one uppercase and one lowercase letter...
                //     ->letters()  // Require at least one letter...
                //     ->numbers() // Require at least one number...
                //     ->symbols() // Require at least one symbol...
            ],
        ]);

        $user = Auth::user();
        $currentTypedPassword = $request->input('password');
        $currentHashedPassword = $user->password;
        $newpassword = $request->input('newpassword');

        // test 1) : mot de passe actuel saisi = mot de passe actuel bdd
        if (Hash::check($currentTypedPassword, $currentHashedPassword)) {

            // test 2) : si ancien et nouveau mdp différents => ok, sinon => erreur
            if ($currentTypedPassword !== $newpassword) {

                $user->password = Hash::make($newpassword);
                $user->save();
                return redirect()->route('user.account')->with('message', 'Le compte a bien été modifié');
            } else {
                return redirect()->route('user.account.edit')->withErrors(['password_error', 'ancien et nouveau mot de passe identiques !']);
            }
        } else {
            return redirect()->route('user.account.edit')->withErrors(['password_error', 'mot de passe actuel saisi incorrect !']);
        }
    }

    public function profil(User $user)
    {
        //$user->load('quacks');
        $messages = Quack::where('user_id', '=', $user->id)->with('comments.user')->get();
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
