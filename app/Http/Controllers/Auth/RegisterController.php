<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'pseudo' => ['required', 'string', 'min:3', 'max:25'],
            'email' => ['required', 'string', 'email', 'min:3', 'max:40'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => [
                'required', 'confirmed',
                Password::min(8) // minimum 8 caractères   
                    ->mixedCase() // Require at least one uppercase and one lowercase letter...
                    ->letters()  // Require at least one letter...
                    ->numbers() // Require at least one number...
                    ->symbols() // Require at least one symbol...       
            ],   // nouvelle syntaxe validation mdp, + d'infos : https://laravel.com/docs/9.x/validation#validating-passwords 
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        // ****************** nouvelle syntaxe (à privilégier) ******************

        return User::create([
            'pseudo' => $data['pseudo'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'image' => isset($data['image']) ? uploadImage($data['image']) : null
        ]);

        // ****************** ancienne syntaxe ******************

        // $user = new User();

        // $user->prenom = $data['prenom'];
        // $user->nom = $data['nom'];
        // $user->pseudo = $data['pseudo'];
        // $user->email = $data['email'];
        // $user->prenom = $data['prenom'];
        // $user->image = isset($data['image']) ? uploadImage($data['image']) : null;
        // $user->password = Hash::make($data['password']);

        // $user->save();
    }
}
