<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Annonce;
use App\AdDel;
use App\Signaler;
use App\AnnonceSaved;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AnnonceController extends Controller
{

    public function adssignalenb()
    {
        $us=Signaler::whereNotNull('ann_id')->get();
        $idd=array();
        $user=0;
        if($us){
            foreach ($us as $value) {
                array_push($idd,$value->ann_id);
            }
            $user=Annonce::whereIn('id', $idd)->get()->count();
        }
        return response($user, Response::HTTP_OK);
    }

    public function annoncesignalee()
    {
        $us=Signaler::whereNotNull('ann_id')->get();
        $idd=array();
        if($us){
            foreach ($us as $value) {
                array_push($idd,$value->ann_id);
            }
            $user=Annonce::whereIn('id', $idd)->get();
            if($user)
                return response($user->jsonSerialize(), Response::HTTP_OK);
        }
        return response(null, Response::HTTP_OK);
    }

    public function adallnb()
    {
        $user=0;
        $user=Annonce::all()->count();
        return response($user, Response::HTTP_OK);
    }
    public function getNotifAdContent(Request $request)
    {
        if($request->has('user_to')){
            $user=User::find($request->input('user_to'));
            return response($user->jsonSerialize(), Response::HTTP_OK);
        }
        if($request->has('ad')){
            $ad=Annonce::find($request->input('ad'));
            return response($ad->jsonSerialize(), Response::HTTP_OK);
        }
        return response(null, Response::HTTP_OK);
    }
    public function getNotifAd(Request $request)
    {
        $ad=Annonce::find($request->input('ad'));
        if($ad){
            return response($ad->jsonSerialize(), Response::HTTP_OK);
        }
        return response(null, Response::HTTP_OK);
    }
    public function adtomod(Request $request)
    {
        $ads=Annonce::find($request->input('ad'));
        if($ads==null)
            return response(null, Response::HTTP_OK);
        return response($ads->jsonSerialize(), Response::HTTP_OK);
    }
    public function delMyAd(Request $request)
    {
        $ad=Annonce::find($request->input('ad'));
        $ads=Annonce::where('categorie',$ad->categorie)->get();
        if($ads){
            foreach ($ads as $value) {
                $value->nbcateg=$value->nbcateg-1;
                $value->save();
            }
        }
        // $del=new AdDel();
        // $del->use_id=$ad->use_id;
        // $del->save();
        $delee = new AdDel();
        $delee->categorie=$ad->categorie;
        $delee->souscateg=$ad->souscateg;
        $delee->description=$ad->description;
        $delee->titre=$ad->titre;
        $delee->prix=$ad->prix;
        $delee->tel=$ad->tel;
        $delee->what=$ad->what;
        $delee->ville=$ad->ville;
        $delee->nbvues=$ad->nbvues;
        $delee->pp=$ad->pp;
        $delee->use_id=$ad->use_id;
        if($request->has('admin')){
            $delee->adm_id=$request->input('admin');
        }
        $delee->save();
        Annonce::destroy($request->input('ad'));
        return response(null, Response::HTTP_OK);
    }
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

    public function admodifying(Request $request)
    {
        $id=$request->input('idad');
        $ad=Annonce::find($id);
        //$count_userAd=Annonce::where('use_id',$request->input('userId'))->count();
        $ad->categorie=$request->input('categ');
        $ad->souscateg=$request->input('scateg');
        $ad->description=$request->input('desc');
        $ad->titre=$request->input('titre');
        $ad->prix=$request->input('prix');
        $ad->tel=$request->input('tel');
        $ad->what=$request->input('isWhat');
        $ad->ville=$request->input('ville');
        $old=$request->input('categ');
        $new=$request->input('oldcateg');
        if($old!=$new){
            $count_categ=Annonce::where('categorie',$request->input('categ'))->count();
            $categ=Annonce::where('categorie',$request->input('categ'))->get();
            if($categ){
                foreach ($categ as $value) {
                    $value->nbcateg=$value->nbcateg+1;
                    $value->save();
                }
            }

            $categ=Annonce::where('categorie',$request->input('oldcateg'))->get();
            if($categ){
                foreach ($categ as $value) {
                    $value->nbcateg=$value->nbcateg-1;
                    $value->save();
                }
            }
            $ad->nbcateg=$count_categ + 1;
        }
        if($request->hasFile('file')){
        //del oldfile
        $fdel=explode(",",$ad->pp);
        foreach ($fdel as $value) {
            Storage::delete('public/'.$request->input('user').'//annonces/'.$value);
        }
        $fname=array();
        $myfile=$request->file;
        foreach ($myfile as $file) {
            array_push($fname,$file->hashName());
            $file->storeAs('public/'.$request->input('user').'//annonces/',$file->hashName());
        }
        $pp=implode(",",$fname); 
        $ad->pp=$pp;
        }
        $ad->save();
        return response( null, Response::HTTP_OK);
    }
    public function picDown(Request $request)
    {
        return Storage::download('public/'.$request->input('user').'/annonces/'.$request->input('ad'));
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
        $categ=Annonce::where('categorie',$request->input('categ'))->get();
        if($categ){
            foreach ($categ as $value) {
                $value->nbcateg=$value->nbcateg+1;
                $value->save();
            }
        }
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
