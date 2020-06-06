<?php

namespace App\Http\Controllers;

use App\Annonce;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnnonceController extends Controller
{

    public function numByCateg(Request $request){
        $count=0;
        $ville=array();
        foreach ($request->place as $place) {
            array_push($ville,$place['name']);
        }
        if(count($ville)==1){
            if(in_array("Tout le pays", $ville))
                $count = Annonce::all()->count();
            else
                $count = Annonce::whereIn('ville',$ville)->count();
        }
        else
            $count = Annonce::whereIn('ville',$ville)->count();
        return $count;
    }

    public function menuCateg(Request $request){

        $adss=new Annonce();
        $ville=array();
        foreach ($request->place as $place) {
            array_push($ville,$place['name']);
        }
        if(count($ville)==1){
            if(in_array("Tout le pays", $ville))
                $adss = Annonce::where('categorie', $request->input('categ'))->get();
            else
                $adss = Annonce::whereIn('ville',$ville)
                ->where('categorie', $request->input('categ'))->get();
        }
        else
            $adss = Annonce::whereIn('ville',$ville)
            ->where('categorie', $request->input('categ'))->get();
        if($adss)
            return response($adss->jsonSerialize(), Response::HTTP_OK);
        return response(null, Response::HTTP_OK);

    }


    public function searchUs(Request $request)
    {
        
        $search=$request->input('search');

        $adss=new Annonce();
        $ville=array();
        foreach ($request->place as $place) {
            array_push($ville,$place['name']);
        }
        if(count($ville)==1){
            if(in_array("Tout le pays", $ville))
                $adss = Annonce::where('categorie', $request->input('selected'))
                ->where(function($query) use($search)  {
                  $query->Where('categorie', 'like', '%' .$search. '%')
                  ->orWhere('souscateg', 'like', '%' . $search . '%')
                  ->orWhere('titre', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
                })->get();
            else
                $adss = Annonce::whereIn('ville',$ville)
                ->where('categorie', $request->input('selected'))
                ->where(function($query) use($search)  {
                  $query->Where('categorie', 'like', '%' .$search. '%')
                  ->orWhere('souscateg', 'like', '%' . $search . '%')
                  ->orWhere('titre', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
                })->get();
        }
        else
            $adss = Annonce::whereIn('ville',$ville)
            ->where('categorie', $request->input('selected'))
            ->where(function($query) use($search)  {
              $query->Where('categorie', 'like', '%' .$search. '%')
              ->orWhere('souscateg', 'like', '%' . $search . '%')
              ->orWhere('titre', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%');
            })->get();
        if($adss)
            return response($adss->jsonSerialize(), Response::HTTP_OK);
        return response(null, Response::HTTP_OK);

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Annonce::all()->jsonSerialize(), Response::HTTP_OK);
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
        $ad = new Annonce();
        /* donner les champs de l'anonnce ajouté a ajouter */
        $ad->save();

        return response(null, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function show($annonce)
    {
        $ads = Annonce::findOrFail($annonce);
        if($ads==null)
            return response(null, Response::HTTP_OK);
        return response($ads->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function edit(Annonce $annonce)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Annonce $annonce)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Annonce  $annonce
     * @return \Illuminate\Http\Response
     */
    public function destroy(Annonce $annonce)
    {
        //
    }
}
