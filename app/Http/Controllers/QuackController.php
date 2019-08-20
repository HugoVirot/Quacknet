<?php

namespace App\Http\Controllers;

use App\Commentaire;
use App\Quack;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;


class QuackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quacks = Quack::with('commentaires.user')->latest()->get();

        return view('home', ['quacks' => $quacks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('quack.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([     //method not found : ignorer, marche quand même (idem digidog)
            'content' => 'required|min:5',
            'image' => '',
            'tags' => '',     //erreur si mdp identique à l'ancien
        ]);

        $user = Auth::user();

        $quack = new Quack;
        $quack->user_id = $user->id;
        $quack->content = $request->input('content');
        $quack->image = $request->input('image');
        $quack->tags = $request->input('tags');
        $quack->save();

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Quack $quack
     * @return \Illuminate\Http\Response
     */

    public function show(Quack $quack)
    {
        $quack2 = Quack::where('id', $quack->id)->with('commentaires.user')->latest()->get();
        return view('quack.show', ['quack' => $quack2]);
    }

    public function read(Quack $quack)
    {

        return view('home');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Quack $quack
     * @return \Illuminate\Http\Response
     */
    public function edit(Quack $quack)
    {
        return view('home');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Quack $quack
     * @return \Illuminate\Http\Response
     */

    public function update(Quack $quack)
    {

        return view('quack.update', ['quack' => $quack]);

    }

    public function updatevalidation(Request $request)
    {
        $request->validate([
            'content' => 'required|min:5',
            'image' => '',
            'tags' => '',
        ]);

        $id = $request->input('id');
        $quack = Quack::where('id', $id)->get();
        $quack->content = $request->input('content');
        if ($request->input('image') !== null) {
            $quack->image = $request->input('image');
        }
        if ($request->input('tags') !== null) {
            $quack->tags = $request->input('tags');
        }
        $quack->user_id = 1;
        $quack->save();
        return redirect()->route('home')->with('message', 'Le Quack a bien été modifié');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Quack $quack
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Quack $quack)
    {

        $quack->delete();
        return redirect()->route('home')->with('message', 'Le Quack a bien été supprimé');
    }
}
