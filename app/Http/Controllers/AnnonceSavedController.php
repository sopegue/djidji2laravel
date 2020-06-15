<?php

namespace App\Http\Controllers;

use App\AnnonceSaved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnonceSavedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(AnnonceSaved::where('use_id',Auth::user()->id)->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function savedAdsCheck(Request $request)
    {
        $ads=AnnonceSaved::where(['use_id'=>$request->input('user'),'ann_id'=>$request->input('ad')])->first();
        $count=0;
        if($ads)
            $count=$ads->count();
        return $count;
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
        $ad=new Ann;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AnnonceSaved  $annonceSaved
     * @return \Illuminate\Http\Response
     */
    public function show($annonceSaved)
    {
        $saved = AnnonceSaved::findOrFail($annonceSaved);
        if($saved==null)
            return response(null, Response::HTTP_OK);
        return response($saved->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AnnonceSaved  $annonceSaved
     * @return \Illuminate\Http\Response
     */
    public function edit(AnnonceSaved $annonceSaved)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AnnonceSaved  $annonceSaved
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AnnonceSaved $annonceSaved)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AnnonceSaved  $annonceSaved
     * @return \Illuminate\Http\Response
     */
    public function destroy(AnnonceSaved $annonceSaved)
    {
        //
    }
}
