<?php

namespace App\Http\Controllers;


use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class CommentController extends Controller
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
            'content' => 'required|min:5',
        ]);

        $user = Auth::user();

        $comment = new Comment;

        // on vérifie si l'utilisateur a le droit de créer le commentaire
        // grâce à la policy correspondante
        $this->authorize('create', $comment);

        $comment->user_id = $user->id;
        $comment->quack_id = $request->input('quack_id');
        $comment->content = $request->input('content');
        $comment->image = isset($request['image']) ? uploadImage($request['image']) : null;
        $comment->tags = $request->input('tags');
        $comment->save();

        return redirect()->route('home');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \app\Models\Quack $quack
     * @return \Illuminate\Http\Response
     */

    public function edit(Comment $comment)
    {
        $this->authorize('update', $comment);

        return view('comment.update', ['comment' => $comment]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \app\Models\Quack $quack
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|min:5',
        ]);

        $comment->content = $request->input('content');
        $comment->image = isset($request['image']) ? uploadImage($request['image']) : $comment->image;
        $comment->tags = $request->input('tags');
        $comment->save();
        return redirect()->route('home')->with('message', 'Le commentaire a bien été modifié');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \app\Models\Quack $quack
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return redirect()->route('home')->with('commentaire', 'Le quack a bien été supprimé');
    }
}
