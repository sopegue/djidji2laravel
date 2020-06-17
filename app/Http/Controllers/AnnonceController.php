<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Annonce;
use App\AnnonceSaved;
use App\User;
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
    
                $adss = $adss->sortByDesc('updated_at')->values();
        
            }
            if($trier=="4"){
                
                $adss = $adss->sortBy('updated_at')->values();
        
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

            $adss = $adss->sortByDesc('updated_at')->values();
    
        }
        if($trier=="4"){
            
            $adss = $adss->sortBy('updated_at')->values();
    
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
    
                $adss = $adss->sortByDesc('updated_at')->values();
        
            }
            if($trier=="4"){
                
                $adss = $adss->sortBy('updated_at')->values();
        
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

            $adss = $adss->sortByDesc('updated_at')->values();
    
        }
        if($trier=="4"){
            
            $adss = $adss->sortBy('updated_at')->values();
    
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

    public function adSaved(Request $request)
    {
        $current=$request->input('curPage');
        $id=$request->input('user');
        $tryads= User::find($id);
        if($tryads){

            $ads=$tryads->annonces->sortByDesc('updated_at')->values();
        
            $count=$ads->count();
            $total=$count;
            if($count%12!=0){
            if($count<12)
                $count=1;
            if($count>12)
                $count=($count/12) + 1;
            }
            else
                $count=$count/12;
            
            $ads = $ads->slice(($current-1)*12,12);
            $adss["ads"]=$ads->jsonSerialize();
            $adss["count"]=$count;
            $adss["total"]=$total;

            return response( $adss, Response::HTTP_OK);
        }else{
            $adss["ads"]=[];
            $adss["count"]=0;
            $adss["total"]=0;
            return response( $adss, Response::HTTP_OK);
        }
            

    }

    public function myadSaved(Request $request)
    {
        $current=$request->input('curPage');
        $adsid=array();
        $id=$request->input('user');
        $tryads= AnnonceSaved::where('use_id',$id)->get();
        if($tryads){
            foreach ($tryads as $saved) {
                array_push($adsid,$saved->ann_id);
            }

            $ads=Annonce::whereIn('id',$adsid)->get();
        
            $count=$ads->count();
            $total=$count;
            if($count%12!=0){
            if($count<12)
                $count=1;
            if($count>12)
                $count=($count/12) + 1;
            }
            else
                $count=$count/12;
            
            $ads = $ads->slice(($current-1)*12,12);
            $adss["ads"]=$ads->jsonSerialize();
            $adss["count"]=$count;
            $adss["total"]=$total;

            return response( $adss, Response::HTTP_OK);
        }else{
            $adss["ads"]=[];
            $adss["count"]=0;
            $adss["total"]=0;
            return response( $adss, Response::HTTP_OK);
        }
            

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

    public function vAnnonce($id)
    {
        $ads=Annonce::find($id);
        if($ads==null)
            return response(null, Response::HTTP_OK);
        return response($ads->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $count_categ=Annonce::where('categorie',$request->input('categ'))->count();
        //$count_userAd=Annonce::where('use_id',$request->input('userId'))->count();
        $ad = new Annonce();
        $ad->categorie=$request->input('categ');
        $ad->souscateg=$request->input('scateg');
        $ad->description=$request->input('desc');
        $ad->titre=$request->input('titre');
        $ad->prix=$request->input('prix');
        $ad->tel=$request->input('tel');
        $ad->what=$request->input('isWhat');
        $ad->ville=$request->input('ville');
        $ad->nbcateg=$count_categ + 1;
        $fname=array();
        $myfile=$request->file;
        foreach ($myfile as $file) {
            array_push($fname,$file->hashName());
            $file->storeAs('public/'.$request->input('user').'//annonces/',$file->hashName());
        }
        $pp=implode(",",$fname); 
        $ad->pp=$pp;
        $ad->use_id=$request->input('user');
        $ad->save();
        return response( $fname, Response::HTTP_OK);
    }


    public function testfile(Request $request){
        
        //$files = $request->file;
        $fname=array();
        foreach ($request->file as $file) {
            array_push($fname,$file->hashName());
            $file->storeAs('//testok/',$file->hashName());
        }
        return response($fname, Response::HTTP_OK);
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
