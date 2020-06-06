<?php

namespace App\Http\Controllers;

use App\Reset;
use Illuminate\Http\Request;

class ResetController extends Controller
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
        $reset = new Reset();

        //

        $reset->save();
        return response(null, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reset  $reset
     * @return \Illuminate\Http\Response
     */
    public function show($reset)
    {
        $reset=Reset::query()->where('use_id',Auth::user()->id)->get();
        if($reset==null)
            return response(null, Response::HTTP_OK);
        return response($reset->jsonSerialize(), Response::HTTP_OK);
        Reset::query()->where('use_id',Auth::user()->id)->where('id',$reset)->where('code',$request->code)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reset  $reset
     * @return \Illuminate\Http\Response
     */
    public function edit(Reset $reset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reset  $reset
     * @return \Illuminate\Http\Response
     */
    public function update($reset)
    {
        $reset = Reset::findOrFail($reset);
        /* donner les champs de l'anonnce ajouté a modifier */
        $reset->save();

        return response(null, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reset  $reset
     * @return \Illuminate\Http\Response
     */
    public function destroy($reset)
    {
        Reset::destroy($reset);
        return response(null, Response::HTTP_OK);
    }
}
