<?php

namespace App\Http\Controllers;

use App\Quack;
use Illuminate\Http\Request;

class QuackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$quacks = Quack::all();
//        return view('index', ['quacks' => $quacks]);
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Quack  $quack
     * @return \Illuminate\Http\Response
     */
    public function read(Quack $quack)
    {
        return view('index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Quack  $quack
     * @return \Illuminate\Http\Response
     */
    public function edit(Quack $quack)
    {
        return view('update');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Quack  $quack
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quack $quack)
    {
        return view('update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Quack  $quack
     * @return \Illuminate\Http\Response
     */
    public function delete(Quack $quack)
    {
        return view('delete');
    }
}
