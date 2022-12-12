<?php

namespace App\Http\Controllers\User;

use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\Quack;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{

    // constructeur de la classe : permet d'appliquer un comportement avant d'accéder à une des méthodes de la classe
    // ici, on véfie que l'utilisateur est bien connecté avec le middleware "auth"

    public function __construct()
    {
        $this->middleware('auth');
    }


    // ************ INDEX : affiche page avec les infos du compte ***************************

    public function index()
    {
        $user = Auth::user();
        return view('user.account', ['user' => $user]);
    }

    // ************ EDIT : affiche page de modification des infos infos du compte *************

    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', ['user' => $user]);
    }


    // ************* UPDATE : permet de valider les modifications effectuées *******************

    public function update(Request $request, User $user)
    {
        $request->validate([
            'pseudo' => 'required|min:3|max:50',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        //on récupère les données de base de l'utilisateur
        $user = Auth::user();

        //on modifie les infos de l'utilisateur
        $user->pseudo = $request->input('pseudo');

        // si une image est uploadée : on la sauvegarde avec le helper uploadImage
        // sinon : on lui donne une valeur nulle
        $user->image = isset($request['image']) ? uploadImage($request['image']) : $user->image;

        $user->save(); // on sauvegarde les changements en bdd

        return redirect()->route('user.account')->with('message', 'Le compte a bien été modifié');
    }


    // ********** UPDATEPASSWORD : permet de valider la modification du mot de passe ************

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'newPassword' => [
                // toutes versions de Laravel confondues
                'required', 'confirmed', 'min:8',

                // ancienne syntaxe avant Laravel 8 
                // 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!$#%@]).*$/'

                // nouvelle syntaxe (laravel 8 et 9)
                Password::min(8) // minimum 8 caractères
                    ->mixedCase() // Require at least one uppercase and one lowercase letter...
                    ->letters()  // Require at least one letter...
                    ->numbers() // Require at least one number...
                    ->symbols() // Require at least one symbol...
            ],
        ]);

        $user = Auth::user();
        $currentTypedPassword = $request->input('password'); // mdp actuel saisi (en clair)
        $currentHashedPassword = $user->password; // mdp actuel en base (hashé)
        $newpassword = $request->input('newpassword'); // nouveau mdp saisi (en clair)

        // test 1) : si mot de passe actuel saisi = mot de passe actuel bdd =>ok, sinon => erreur
        if (Hash::check($currentTypedPassword, $currentHashedPassword)) {

            // test 2) : si ancien et nouveau mdp différents => ok, sinon => erreur
            if ($currentTypedPassword !== $newpassword) {

                $user->password = Hash::make($newpassword); // on remplace l'ancien mdp par le nouveau (que l'on hashe)
                $user->save();                              // on sauvegarde le changement en bdd
                return redirect()->route('user.account')->with('message', 'Le compte a bien été modifié');
            } else {
                return redirect()->route('user.account.edit')->withErrors(['password_error', 'ancien et nouveau mot de passe identiques !']);
            }
        } else {
            return redirect()->route('user.account.edit')->withErrors(['password_error', 'mot de passe actuel saisi incorrect !']);
        }
    }


    // ****************** PROFIL : affiche le profil public (type Facebook) ******************

    public function profil(User $user)
    {
        //$user->load('quacks');
        $messages = Quack::where('user_id', '=', $user->id)->with('comments.user')->get();
        return view('user.profil', compact('user'));
    }


    // *********************** DESTROY : pour supprimer l'utilisateur *********************

    public function destroy(User $user)
    {
        // on vérifie que c'esrt bien l'utilisateur connecté qui fait la demande de suppression
        // (les id doivent être identiques)
        if (Auth::user()->id == $user->id) {
            $user->delete();                    // on réalise la suppression
            return redirect()->route('index')->with('message', 'Le compte a bien été supprimé');
        } else {
            return redirect()->back()->withErrors(['erreur' => 'suppression du compte impossible']);
        }
    }
}
