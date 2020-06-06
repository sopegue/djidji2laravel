<?php

namespace App\Http\Controllers;

use App\Adresse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AdresseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Adresse::where('use_id',Auth::user()->id)->first()->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        $adress = new Adresse();
        /* donner l'adresse entrer par le user lors de la creation de compte */
        $adress->save();

        return response(null, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Adresse  $adresse
     * @return \Illuminate\Http\Response
     */
    public function show($adresse)
    {
        $adress = Adresse::findOrFail($adresse);
        if($adress==null)
            return response(null, Response::HTTP_OK);
        return response($adress->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Adresse  $adresse
     * @return \Illuminate\Http\Response
     */
    public function edit($adresse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Adresse  $adresse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $adresse)
    {
        
        $adress = Adresse::findOrFail($adresse);
        /* donner les champs de l'adresse modifier */
        $adress->save();

        return response(null, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Adresse  $adresse
     * @return \Illuminate\Http\Response
     */
    public function destroy($adresse)
    {
        Adresse::destroy($adresse);
        return response(null, Response::HTTP_OK);
    }
}
