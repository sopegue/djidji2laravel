<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use App\Signaler;
use Illuminate\Http\Request;

class SignalerController extends Controller
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
    public function store(Request $request/* id annonce*/)
    {
        $sign=new Signaler();
        if($request->has('user')){
            $sign->use_id=$request->input('user');
        }
        $sign->ann_id=$request->input('ad');
        $sign->save();
        return response(null, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Signaler  $signaler
     * @return \Illuminate\Http\Response
     */
    public function show(Signaler $signaler)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Signaler  $signaler
     * @return \Illuminate\Http\Response
     */
    public function edit(Signaler $signaler)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Signaler  $signaler
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Signaler $signaler)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Signaler  $signaler
     * @return \Illuminate\Http\Response
     */
    public function destroy(Signaler $signaler)
    {
        //
    }
}
