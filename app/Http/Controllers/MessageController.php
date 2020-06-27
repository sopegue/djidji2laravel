<?php

namespace App\Http\Controllers;
use App\Signaler;
use App\User;
use App\Message;
use App\AdMess;
use App\Visit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\contact;
use App\ContactUs;
use App\Mail\contactMail;
use App\Mail\MessageDeDjidji;
class MessageController extends Controller
{

    public function checkNotif(Request $request)
    {
        $count=0;
        $notif=Message::where('to_user',$request->input('user'))->get();
        if($notif){
            foreach ($notif as $value) {
                if($value->seen==0)
                {
                    $count=100;
                }
            }
        }
        return response($count, Response::HTTP_OK);
    }

    public function getNotif(Request $request)
    {
    
        $notif=Message::where('to_user',$request->input('user'))->get();
        if($notif){
            return response($notif->jsonSerialize(), Response::HTTP_OK);
        }
        return response(null, Response::HTTP_OK);
    }

    public function getNotifAd()
    {
        $not=Signaler::all();
        if($not){
            return response($not->jsonSerialize(), Response::HTTP_OK);
        }
        return response(null, Response::HTTP_OK);
    }

    public function getMess(Request $request)
    {
    
        $notif=AdMess::where('to_user',$request->input('user'))->get();
        $count=0;
        if($notif){
            foreach ($notif as $value) {
                foreach ($notif as $key) {
                    if($value->use_id==$key->use_id)
                    $count++;
                }
                $value["nb"]=$count;
                $count=0;
            }
            return response($notif->jsonSerialize(), Response::HTTP_OK);
        }
        return response(null, Response::HTTP_OK);
    }


    public function getAdmMessage(Request $request)
    {
    
        $last=AdMess::where(['to_user'=>$request->input('me'),'use_id'=>$request->input('user')])->latest()->first();
        $user=User::find($last->use_id);
        $notif=AdMess::where(['to_user'=>$request->input('me'),'use_id'=>$request->input('user')])->get();
        if($notif){
            foreach ($notif as $value) {
                $value->seen=1;
                $value->save();
                $value["Nom"]=$user->Nom;
                $value["pp"]=$user->pp;
                $value["respond"]=false;
            }
            return response($notif->jsonSerialize(), Response::HTTP_OK);
        }
        return response(null, Response::HTTP_OK);
    }


    public function getAdmMessageRespond(Request $request)
    {
    
        
        $notif=AdMess::find($request->input('id'));
        if($notif){
            $notif->response=$request->input('message');
            $notif->save();
        }
        return response(null, Response::HTTP_OK);
    }
    public function getContactUs()
    {
    
        $notif=ContactUs::all();
        if($notif){
            return response($notif->jsonSerialize(), Response::HTTP_OK);
        }
        return response(null, Response::HTTP_OK);
    }

    public function incrementVisit()
    {
        $visiteurs=0;
        $notif=Visit::find(1);
        if($notif){
            $notif->nb=$notif->nb+1;
            $visiteurs=$notif->nb;
            $notif->save();
        }
        return response($visiteurs, Response::HTTP_OK);
    }

    public function getContactUsNb()
    {
        $count=0;
        $notif=ContactUs::all();
        if($notif){
            foreach ($notif as $value) {
                if($value->seen==0)
                {
                    $count++;
                }
            }
        }
        return response($count, Response::HTTP_OK);
    }

    public function notVue(Request $request)
    {
    
        $notif=Message::find($request->input('notif'));
        if($notif){
            $notif->seen=1;
            $notif->save();
        }
        return response(null, Response::HTTP_OK);
    }

    public function contactusvue(Request $request)
    {
    
        $notif=ContactUs::find($request->input('notif'));
        if($notif){
            $notif->seen=1;
            $notif->save();
        }
        return response(null, Response::HTTP_OK);
    }

    public function notVueAdminn(Request $request)
    {
    
        $notif=Signaler::find($request->input('notif'));
        if($notif){
            $notif->admseen=1;
            $notif->save();
        }
        return response(null, Response::HTTP_OK);
    }
    

    public function checkNotifNb(Request $request)
    {
        $count=0;
        $notif=Message::where('to_user',$request->input('user'))->get();
        if($notif){
            foreach ($notif as $value) {
                if($value->seen==0)
                {
                    $count++;
                }
            }
        }
        return response($count, Response::HTTP_OK);
    }
    public function checkAdmNotifNb(Request $request)
    {
        $count=0;
        $notif=Signaler::all();
        if($notif){
            foreach ($notif as $value) {
                if($value->admseen==0)
                {
                    $count++;
                }
            }
        }
        return response($count, Response::HTTP_OK);
    }
    public function checkMessNb(Request $request)
    {
        $count=0;
        $notif=AdMess::where('to_user',$request->input('user'))->get();
        if($notif){
            foreach ($notif as $value) {
                if($value->seen==0)
                {
                    $count++;
                }
            }
        }
        return response($count, Response::HTTP_OK);
    }
    public function sendMessage(Request $request)
    {
        $message=new Message();
        if($request->has('user')){
            $message->use_id=$request->input('user');
        }
        $message->name=$request->input('name');
        $message->ann_id=$request->input('ad');
        $message->email=$request->input('email');
        $message->content=$request->input('message');
        $message->to_user=$request->input('to_user');
        $message->save();
        Mail::to($request->input('toemail'))
            ->send(new MessageDeDjidji($request));
        return response(null, Response::HTTP_OK);
    }
    public function sendMessageAdmin(Request $request)
    {
        $message=new AdMess();
        $message->use_id=$request->input('user');
        $message->name=$request->input('name');
        $message->content=$request->input('message');
        $message->to_user=$request->input('to_user');
        $message->save();
        return response(null, Response::HTTP_OK);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Message::query()->where('use_id',Auth::user()->id)->orWhere('receiver',Auth::user()->id)->get()->jsonSerialize(), Response::HTTP_OK);
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
        $sms = new Message();
        /* donner l'adresse entrer par le user lors de la creation de compte */
        $sms->save();
        return response(null, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show($message)
    {
        $sms = Message::query()->where(function ($query) { $query->where('use_id',Auth::user()->id)->where('receiver',$message);})->orWhere(function($query) {$query->where('use_id',$message)->where('receiver',Auth::user()->id);})->get();
        if($sms==null)
            return response(null, Response::HTTP_OK);
        return response($sms->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy($message)
    {
       
        foreach ($sms as $beDel) {
            $beDel->delete();
        }
        return response(null, Response::HTTP_OK);
    }
}
