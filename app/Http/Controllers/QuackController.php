<?php

namespace App\Http\Controllers;

use App\Quack;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class QuackController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth')->except(['search', 'show']);
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
        $request->validate([
            'content' => 'required|min:5',
            'image' => '',
            'tags' => '',
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
        return view('quack.show', ['quack' => $quack,]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Quack $quack
     * @return \Illuminate\Http\Response
     */

    public function edit(Quack $quack)
    {
        return view('quack.update', ['quack' => $quack]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Quack $quack
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Quack $quack)
    {
        $request->validate([
            'content' => 'required|min:5',
            'image' => 'present',
            'tags' => 'present',
        ]);

        $quack->content = $request->input('content');
        if ($request->input('image') !== null) {
            $quack->image = $request->input('image');
        }
        if ($request->input('tags') !== null) {
            $quack->tags = $request->input('tags');
        }

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
        if (Auth::user()->id == $quack->user_id || Auth::user()->roles_id == 2) {
            $quack->delete();
            return redirect()->route('home')->with('message', 'Le quack a bien été supprimé');
        } else {
            return redirect()->back()->withErrors(['erreur' => 'suppression impossible']);
        }
    }


    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required',
        ]);

        $recherche = $request->input('q');

        // $quacks = DB::select('select * from quacks where tags like ?', ["%" . $recherche . "%"]);
        $quacks = DB::table('quacks')
            ->where('quacks.tags', 'like', "%$recherche%")
            ->orWhere('quacks.content', 'like', "%$recherche%")
            ->join('users', 'quacks.user_id', '=', 'users.id')
            // ->leftJoin('comments', 'quacks.id', '=', 'comments.quack_id')
            // ->select('users.*', 'quacks.*', 'comments.content as commentcontent')
            ->get();
        return view('quack.searchresults', ['quacks' => $quacks]);
    }
}
