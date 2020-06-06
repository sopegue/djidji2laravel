<?php

namespace App\Http\Controllers;

use App\VisualiseOuRecherche;
use Illuminate\Http\Request;

class VisualiseOuRechercheController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return response(VisualiseOuRecherche::all()->jsonSerialize(), Response::HTTP_OK);
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
        $vis=new VisualiseOuRecherche();

        //

        $vis->save();
        return response(null, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\VisualiseOuRecherche  $visualiseOuRecherche
     * @return \Illuminate\Http\Response
     */
    public function show(VisualiseOuRecherche $visualiseOuRecherche)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\VisualiseOuRecherche  $visualiseOuRecherche
     * @return \Illuminate\Http\Response
     */
    public function edit(VisualiseOuRecherche $visualiseOuRecherche)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\VisualiseOuRecherche  $visualiseOuRecherche
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VisualiseOuRecherche $visualiseOuRecherche)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\VisualiseOuRecherche  $visualiseOuRecherche
     * @return \Illuminate\Http\Response
     */
    public function destroy(VisualiseOuRecherche $visualiseOuRecherche)
    {
        //
    }
}
