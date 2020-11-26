<?php

namespace App\Http\Controllers;


use App\Comment;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CommentController extends Controller
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
        ]);

        $user = Auth::user();

        $comment = new Comment;
        $comment->user_id = $user->id;
        $comment->quack_id = $request->input('quack_id');
        $comment->content = $request->input('content');
        $comment->image = $request->input('image');
        $comment->save();

        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Quack $quack
     * @return \Illuminate\Http\Response
     */

    public function show(Comment $comment)
    {
        $comment->load(['user', 'comments.user']);

        return view('quack.show', ['quack' => $comment]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Quack $quack
     * @return \Illuminate\Http\Response
     */

    public function edit(Comment $comment)
    {
        return view('comment.update', ['comment' => $comment]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Quack $quack
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|min:5',
            'image' => 'present',
        ]);

        $comment->content = $request->input('content');
        if ($request->input('image') !== null) {
            $comment->image = $request->input('image');
        }

        $comment->save();
        return redirect()->route('home')->with('message', 'Le commentaire a bien été modifié');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Quack $quack
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */

    public function destroy(Comment $comment)
    {
        if (Auth::user()->id == $comment->user_id || Auth::user()->roles_id == 2) {
            $comment->delete();
            return redirect()->route('home')->with('commentaire', 'Le quack a bien été supprimé');
        } else {
            return redirect()->back()->withErrors(['erreur' => 'suppression impossible']);
        }
    }
}
