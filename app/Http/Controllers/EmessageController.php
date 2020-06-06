<?php

namespace App\Http\Controllers;

use App\Emessage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return response(Emessage::all()->jsonSerialize(), Response::HTTP_OK);
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
        $em = new Emessage();
        /* donner l'adresse entrer par le user lors de la creation de compte */
        $em->save();

        return response(null, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Emessage  $emessage
     * @return \Illuminate\Http\Response
     */
    public function show(Emessage $emessage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Emessage  $emessage
     * @return \Illuminate\Http\Response
     */
    public function edit(Emessage $emessage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Emessage  $emessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Emessage $emessage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Emessage  $emessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Emessage $emessage)
    {
        //
    }
}
