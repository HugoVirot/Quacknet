<?php

namespace App\Http\Controllers;

use App\Models\Quack;
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
        // on valide les infos du formulaire en précisant les critères attendus
        $request->validate([
            'content' => 'required|min:5|max:500',
            'tags' => 'required|min:3|max:50',
            'image' => 'image|nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user(); // on récupère l'utilisateur connecté
 
        // *********** syntaxe 1 ******************
        $quack = new Quack; // on créé un nouveau message

        // pb de policies à régler
        // $this->authorize('create', $quack);

        // j'accède aux propriétés de mon message et je leur donne des valeurs
        $quack->user_id = $user->id; 
        $quack->content = $request->input('content');
        $quack->image = isset($request['image']) ? uploadImage($request['image']) : null;
        $quack->tags = $request->input('tags');

        // je sauvegarde en base de données
        $quack->save();

        // *********** syntaxe 2 ******************
        // Quack::create([
        //     'user_id' => $user->id,
        //     'content' => $request->input('content'),
        //     'tags' => $request->input('tags'),
        //     'image' => isset($data['image']) ? uploadImage($data['image']) : null
        // ]);

        return redirect()->route('home')->with('message', 'Le quack a bien été sauvegardé');
    }


    /**
     * Display the specified resource.
     *
     * @param \app\Models\Quack $quack
     * @return \Illuminate\Http\Response
     */

    public function show(Quack $quack)
    {
        return view('quack.show', ['quack' => $quack]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \app\Models\Quack $quack
     * @return \Illuminate\Http\Response
     */

    public function edit(Quack $quack)
    {
        //$this->authorize('update', $quack);

        return view('quack.update', ['quack' => $quack]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \app\Models\Quack $quack
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Quack $quack)
    {
        //$this->authorize('update', $quack);

        $request->validate([
            'content' => 'required|min:5|max:500',
            'tags' => 'min:3|max:50',
        ]);

        $quack->content = $request->input('content');
        $quack->image = isset($request['image']) ? uploadImage($request['image']) : $quack->image;
        $quack->tags = $request->input('tags');

        $quack->save();

        return redirect()->route('home')->with('message', 'Le Quack a bien été modifié');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \app\Models\Quack $quack
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
