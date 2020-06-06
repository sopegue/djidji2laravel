<?php

namespace App\Http\Controllers;

use App\Verification;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store($request)
    {
        $verify=new Verification();

        //

        $verify->save();
        return response(null, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Verification  $verification
     * @return \Illuminate\Http\Response
     */
    public function show($verification)
    {
        $verify=Verification::query()->where('use_id',Auth::user()->id)->get();
        if($verify==null)
            return response(null, Response::HTTP_OK);
        return response($verify->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Verification  $verification
     * @return \Illuminate\Http\Response
     */
    public function edit($verification/* reset id*/)
    {
        $verify=new Verification();

        //Verification with reset

        $verify->save();
        return response(null, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Verification  $verification
     * @return \Illuminate\Http\Response
     */
    public function update($verification)
    {
        $verify = Verification::findOrFail($verification);
        /* donner les champs de l'anonnce ajouté a modifier */
        $verify->save();

        return response(null, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Verification  $verification
     * @return \Illuminate\Http\Response
     */
    public function destroy($verification)
    {
        Verification::destroy($verification);
        return response(null, Response::HTTP_OK);
    }
}
