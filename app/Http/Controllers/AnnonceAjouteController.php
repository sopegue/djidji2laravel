<?php

namespace App\Http\Controllers;

use App\AnnonceAjoute;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AnnonceAjouteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(AnnonceAjoute::where('use_id',Auth::user()->id)->get()->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\AnnonceAjoute  $annonceAjoute
     * @return \Illuminate\Http\Response
     */
    public function show($annonceAjoute)
    {
        $ads = AnnonceAjoute::findOrFail($annonceAjoute);
        if($ads==null)
            return response(null, Response::HTTP_OK);
        return response($ads->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AnnonceAjoute  $annonceAjoute
     * @return \Illuminate\Http\Response
     */
    public function edit(AnnonceAjoute $annonceAjoute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AnnonceAjoute  $annonceAjoute
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$annonceAjoute)
    {
        $annonceAjoute = AnnonceAjoute::findOrFail($annonceAjoute);
        /* donner les champs de l'anonnce ajouté a modifier */
        $annonceAjoute->save();

        return response(null, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AnnonceAjoute  $annonceAjoute
     * @return \Illuminate\Http\Response
     */
    public function destroy($annonceAjoute)
    {
        AnnonceAjoute::destroy($annonceAjoute);
        return response(null, Response::HTTP_OK);
    }
}
