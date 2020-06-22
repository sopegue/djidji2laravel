<?php

namespace App\Http\Controllers;
use App\User;
use App\Verification;
use Illuminate\Http\Request;
use App\Message;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\contact;
use App\Mail\contactMail;
use App\Mail\DemandeDeReinitialisationDeMotDePasse;

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
    public function store(Request $request)
    {
        $user=User::where('email',$request->input('email'))->first();
        $code=0;
        if($user){
            $checks=Verification::where('use_id',$user->id)->get();
            if($checks){
                foreach ($checks as $ver) {
                    if($ver->verified==0)
                        Verification::destroy($ver->id);
                }
            }
            $check=new Verification();
            $check->use_id=$user->id;
            $code=rand(100000,999999);
            $check->code=$code;
            $check->verified=0;
            $check->save();

            // phase de l'envoi
            Mail::to($request->input('email'))
            ->send(new DemandeDeReinitialisationDeMotDePasse($code));

        }
        
        return response($code, Response::HTTP_OK);
    }
    
    public function checkcode(Request $request)
    {
        $user=User::where('email',$request->input('email'))->first();
        $code=0;
        if($user){
            $checks=Verification::where('use_id',$user->id)->get();
            if($checks){
                foreach ($checks as $ver) {
                    if($ver->verified==0)
                        {
                            if($ver->code==$request->input('code'))
                            {
                                $ver->verified=1;
                                
                                $code=45;

                                $ver->save();
                            }
                            
                        }
                }
            }

        }
        
        return response($code, Response::HTTP_OK);
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
