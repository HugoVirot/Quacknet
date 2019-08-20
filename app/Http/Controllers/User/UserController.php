<?php

namespace App\Http\Controllers\User;

use App\Quack;
use Auth;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()            //affiche page avec les infos du compte
    {
        $user = Auth::user();

        return view('user.account', ['user' => $user]);
    }


    public function updatepage()    //affiche formulaire modification infos
    {
        $user = Auth::user();

        return view('user.accountupdatepage', ['user' => $user]);
    }


    public function updatevalidation(Request $request)      //permet de valider les modifs
    {
        $request->validate([     //method not found : ignorer, marche quand même (idem digidog)
            'prenom' => 'max:50',
            'nom' => 'max:50',
            'password' => '',     //erreur si mdp identique à l'ancien
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

    public function profil($id)
    {
//        $quacks = DB::table('quacks')->where('user_id', $id);
//        $user = DB::table('users')->where('id', $id);
        $quacks = Quack::where('user_id', $id)->get();
        $user = User::where('id', $id)->get();
        return view('user/profil', ['quacks' => $quacks, 'user' => $user]);
    }
}



//        protected function validator(array $data)
//    {
//        return Validator::make($user, [
//            'prenom' => ['required', 'string', 'max:30'],
//            'nom' => ['required', 'string', 'max:30'],
////            'duckname' => ['required', 'string', 'max:255'],
////            'email' => ['required', 'string', 'email', 'max:255'],
//            'password' => ['required', 'string', 'min:8', 'confirmed'],
//        ]);
//    }
//
//    validator($user);

//return User::create([
//'prenom' => $data['prenom'],
//'nom' => $data['nom'],
//'duckname' => $data['duckname'],
//'email' => $data['email'],
//'password' => Hash::make($data['password']),
//]);

//    public function update(Request $request, User $user)      //validation infos modifiées
//    {
//        $validatedData = $request->validate([     //method not found : ignorer, marche quand même (idem digidog)
//            'prenom' => 'required|max:50',
//            'nom' => 'required|max:50',
//            'duckname' => 'max:50',
//            'email' => 'max:30',
//            'password' => 'required|min:8',
//        ]);
//
//        $user->prenom = $request->input('prenom');
//        $user->nom = $request->input('nom');
//        $user->duckname = $validatedData['duckname'];
//        $user->email = $validatedData['email'];
//        $user->password = $request->input('password');
//        $user->save();
//        return view('user.myaccount', ['user' => $user]);
////        return redirect()->route('myaccount');
//    }
