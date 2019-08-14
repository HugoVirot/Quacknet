<?php

namespace App\Http\Controllers\User;

use Auth;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()            //affiche page avec les infos du compte
    {
        $user = Auth::user();
        return view('user.myaccount', ['user' => $user]);
    }

    public function updateaccount()    //affiche formulaire modification infos
    {
        $user = Auth::user();
        return view('user.updateaccount',['user' => $user]);
    }

    public function update(Request $request, User $user)      //validation infos modifiées
    {
        $validatedData = $request->validate([     //method not found : ignorer, marche quand même (idem digidog)
            'prenom' => 'required|max:50',
            'nom' => 'required|max:50',
            'password' => 'required|min:8',
        ]);

        $user->prenom = $validatedData['prenom'];
        $user->nom = $validatedData['nom'];
        $user->password = $validatedData['password'];
        $user->save();
        return view('user.myaccount',['user' => $user]);
//        return redirect()->route('myaccount');
    }
}
