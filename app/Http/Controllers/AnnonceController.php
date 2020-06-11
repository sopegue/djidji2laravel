<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
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

    public function sousCategSearch(Request $request){
        
        $adss=new Annonce();
        $current=$request->input('curPage');
        $trier=$request->input('trier');
        $prmin=$request->input('prmin');
        $ville=array();
        foreach ($request->place as $place) {
            array_push($ville,$place['name']);
        }
        if(count($ville)==1){
            if(in_array("Tout le pays", $ville))
                $adss = Annonce::where('prix','>=',$prmin)->where(['categorie'=> $request->input('categ'),'souscateg'=> $request->input('scateg')])
                ->get();
            else
                $adss = Annonce::whereIn('ville',$ville)->where('prix','>=',$prmin)
                ->where(['categorie'=> $request->input('categ'),'souscateg'=> $request->input('scateg')])
                ->get();
        }
        else
            $adss = Annonce::whereIn('ville',$ville)->where('prix','>=',$prmin)
            ->where(['categorie'=> $request->input('categ'),'souscateg'=> $request->input('scateg')])
            ->get();

            $count=$adss->count();
            $total=$count;
            if($count%16!=0){
            if($count<16)
                $count=1;
            if($count>16)
                $count=($count/16) + 1;
            }
            else
                $count=$count/16;
    
            if($trier=="1"){
    
            $adss = $adss->sortBy('prix')->values();
    
            }
            if($trier=="2"){
                
                $adss = $adss->sortByDesc('prix')->values();
        
            }
    
            if($trier=="3"){
    
                $adss = $adss->sortByDesc('added_at')->values();
        
            }
            if($trier=="4"){
                
                $adss = $adss->sortBy('added_at')->values();
        
            }
    
            if($current==1){
                $adss = $adss->slice(0,16);
            }
            else
                $adss = $adss->slice(($current-1)*16,16);
            
            $ads["ads"]=$adss->jsonSerialize();
            $ads["count"]=$count;
            $ads["total"]=$total;
    
            if($ads)
                return response( json_encode($ads), Response::HTTP_OK);
            return response(null, Response::HTTP_OK);

    }

    public function whatLook(Request $request){

        $count=0;
        $current=$request->input('curPage');
        $trier=$request->input('trier');
        $prmin=$request->input('prmin');
        

        $adss=new Annonce();
        $ville=array();
        foreach ($request->place as $place) {
            array_push($ville,$place['name']);
        }
        if(count($ville)==1){

            if($request->input('look')=='A la une'){
                if(in_array("Tout le pays", $ville)){
                    $adss = Annonce::where('prix','>=',$prmin)
                    ->orderBy('nbvues', 'desc')->get();
                
            }
            else
                $adss = Annonce::whereIn('ville',$ville)
                ->where('prix','>=',$prmin)
                ->orderBy('nbvues', 'desc')->get();
            }

            if($request->input('look')=='Economiques'){
                if(in_array("Tout le pays", $ville))
                $adss = Annonce::where('prix','>=',$prmin)
                ->orderBy('prix', 'asc')->get();
            else
                $adss = Annonce::whereIn('ville',$ville)
                ->where('prix','>=',$prmin)
                ->orderBy('prix', 'asc')->get();
            }

            if($request->input('look')=='Top catégories'){
                
                if(in_array("Tout le pays", $ville))
                $adss = Annonce::where('prix','>=',$prmin)
                ->orderBy('nbcateg', 'desc')->get();
            else
            $adss = Annonce::whereIn('ville',$ville)
            ->where('prix','>=',$prmin)
            ->orderBy('nbcateg', 'desc')->get();
            }
            
        }
        else{

            if($request->input('look')=='A la une'){
                $adss = Annonce::whereIn('ville',$ville)
                 ->where('prix','>=',$prmin)
                ->orderBy('nbvues', 'desc')->get();
            }

            if($request->input('look')=='Economiques'){
                $adss = Annonce::whereIn('ville',$ville)
                 ->where('prix','>=',$prmin)
                ->orderBy('prix', 'asc')->get();
            }
            
            if($request->input('look')=='Top catégories'){
                $adss = Annonce::whereIn('ville',$ville)
                 ->where('prix','>=',$prmin)
                ->orderBy('nbcateg', 'desc')->get();
            }

        }

        $count=$adss->count();
        $total=$count;
        if($count%16!=0){
        if($count<16)
            $count=1;
        if($count>16)
            $count=($count/16) + 1;
        }
        else
            $count=$count/16;

        if($trier=="1"){

        $adss = $adss->sortBy('prix')->values();

        }
        if($trier=="2"){
            
            $adss = $adss->sortByDesc('prix')->values();
    
        }

        if($trier=="3"){

            $adss = $adss->sortByDesc('added_at')->values();
    
        }
        if($trier=="4"){
            
            $adss = $adss->sortBy('added_at')->values();
    
        }

        if($current==1){
            $adss = $adss->slice(0,16);
        }
        else
            $adss = $adss->slice(($current-1)*16,16);
        
        $ads["ads"]=$adss->jsonSerialize();
        $ads["count"]=$count;
        $ads["total"]=$total;

        if($ads)
            return response( json_encode($ads), Response::HTTP_OK);
        return response(null, Response::HTTP_OK);

    }

    public function menuCateg(Request $request){

        $adss=new Annonce();
        $current=$request->input('curPage');
        $trier=$request->input('trier');
        $prmin=$request->input('prmin');
        
        $ville=array();
        foreach ($request->place as $place) {
            array_push($ville,$place['name']);
        }
        if(count($ville)==1){
            if(in_array("Tout le pays", $ville))
                $adss = Annonce::where('prix','>=',$prmin)->where('categorie', $request->input('categ'))->get();
            else
                $adss = Annonce::whereIn('ville',$ville)->where('prix','>=',$prmin)
                ->where('categorie', $request->input('categ'))->get();
        }
        else
            $adss = Annonce::whereIn('ville',$ville)->where('prix','>=',$prmin)
            ->where('categorie', $request->input('categ'))->get();
        
            $count=$adss->count();
            $total=$count;
            if($count%16!=0){
            if($count<16)
                $count=1;
            if($count>16)
                $count=($count/16) + 1;
            }
            else
                $count=$count/16;
    
            if($trier=="1"){
    
            $adss = $adss->sortBy('prix')->values();
    
            }
            if($trier=="2"){
                
                $adss = $adss->sortByDesc('prix')->values();
        
            }
    
            if($trier=="3"){
    
                $adss = $adss->sortByDesc('added_at')->values();
        
            }
            if($trier=="4"){
                
                $adss = $adss->sortBy('added_at')->values();
        
            }
    
            if($current==1){
                $adss = $adss->slice(0,16);
            }
            else
                $adss = $adss->slice(($current-1)*16,16);
            
            $ads["ads"]=$adss->jsonSerialize();
            $ads["count"]=$count;
            $ads["total"]=$total;
    
            if($ads)
                return response( json_encode($ads), Response::HTTP_OK);
            return response(null, Response::HTTP_OK);

    }


    public function searchUs(Request $request)
    {
        
        $search=$request->input('search');
        $current=$request->input('curPage');
        $trier=$request->input('trier');
        $prmin=$request->input('prmin');

        $adss=new Annonce();
        $ville=array();
        foreach ($request->place as $place) {
            array_push($ville,$place['name']);
        }
        if(count($ville)==1){
            if(in_array("Tout le pays", $ville)){
                if($request->input('selected')=="Toutes les catégories")   
                $adss = Annonce::where('prix','>=',$prmin)->where(function($query) use($search)  {
                  $query->where('categorie', 'like', '%' .$search. '%')
                  ->orWhere('souscateg', 'like', '%' . $search . '%')
                  ->orWhere('titre', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
                })->get();
                else
                $adss = Annonce::where('categorie', $request->input('selected'))
                ->where('prix','>=',$prmin)
                ->where(function($query) use($search)  {
                  $query->where('categorie', 'like', '%' .$search. '%')
                  ->orWhere('souscateg', 'like', '%' . $search . '%')
                  ->orWhere('titre', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
                })->get();
            }
            else{
                if($request->input('selected')=="Toutes les catégories")
                $adss = Annonce::whereIn('ville',$ville)
                ->where('prix','>=',$prmin)
                ->where(function($query) use($search)  {
                  $query->where('categorie', 'like', '%' .$search. '%')
                  ->orwhere('souscateg', 'like', '%' . $search . '%')
                  ->orWhere('titre', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
                })->get();
                else
                $adss = Annonce::whereIn('ville',$ville)
                ->where('categorie', $request->input('selected'))
                ->where('prix','>=',$prmin)
                ->where(function($query) use($search)  {
                  $query->where('souscateg', 'like', '%' . $search . '%')
                  ->orWhere('titre', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
                })->get();

            }
        }
        else{
            if($request->input('selected')=="Toutes les catégories")
            $adss = Annonce::whereIn('ville',$ville)
            ->where('prix','>=',$prmin)
            ->where(function($query) use($search)  {
            $query->where('categorie', 'like', '%' .$search. '%')
              ->orWhere('souscateg', 'like', '%' . $search . '%')
              ->orWhere('titre', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%');
            })->get();

            else
            $adss = Annonce::whereIn('ville',$ville)
            ->where('categorie', $request->input('selected'))
            ->where('prix','>=',$prmin)
            ->where(function($query) use($search)  {
            $query->where('souscateg', 'like', '%' . $search . '%')
              ->orWhere('titre', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%');
            })->get();
        }

        $count=$adss->count();
        $total=$count;
        if($count%16!=0){
        if($count<16)
            $count=1;
        if($count>16)
            $count=($count/16) + 1;
        }
        else
            $count=$count/16;

        if($trier=="1"){

        $adss = $adss->sortBy('prix')->values();

        }
        if($trier=="2"){
            
            $adss = $adss->sortByDesc('prix')->values();
    
        }

        if($trier=="3"){

            $adss = $adss->sortByDesc('added_at')->values();
    
        }
        if($trier=="4"){
            
            $adss = $adss->sortBy('added_at')->values();
    
        }

        if($current==1){
            $adss = $adss->slice(0,16);
        }
        else
            $adss = $adss->slice(($current-1)*16,16);
        
        $ads["ads"]=$adss->jsonSerialize();
        $ads["count"]=$count;
        $ads["total"]=$total;

        if($ads)
            return response( json_encode($ads), Response::HTTP_OK);
        return response(null, Response::HTTP_OK);

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adss =  Annonce::all();
        $adss = $adss->sortByDesc('prix')->values();
        return response($adss, Response::HTTP_OK);
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
