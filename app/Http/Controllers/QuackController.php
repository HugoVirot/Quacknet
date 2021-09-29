<?php

namespace App\Http\Controllers;

use App\Quack;
use Auth;
use Illuminate\Http\Request;

class QuackController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
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
            'content' => 'required|min:5|max:500',
            'tags' => 'required|min:3|max:50',
        ]);

        $user = Auth::user();

        $quack = new Quack;

        $this->authorize('create', $quack);

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
        return view('quack.show', ['quack' => $quack]);
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
        $this->authorize('update', $quack);

        $request->validate([
            'content' => 'required|min:5|max:500',
            'tags' => 'min:3|max:50',
        ]);

        $quack->content = $request->input('content');
        $quack->image = $request->input('image');
        $quack->tags = $request->input('tags');

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
        $this->authorize('delete', $quack);
        $quack->delete();
        return redirect()->route('home')->with('message', 'Le quack a bien été supprimé');
    }


    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|max:20',
        ]);

        $recherche = $request->input('q');

        $quacks = Quack::where('quacks.tags', 'like', "%$recherche%")
            ->orWhere('quacks.content', 'like', "%$recherche%")
            ->with('user', 'comments.user')
            ->latest()->paginate(10);

        return view('quack.searchresults', ['quacks' => $quacks]);
    }
}
