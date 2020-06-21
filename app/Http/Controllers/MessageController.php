<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\contact;
use App\Mail\contactMail;
use App\Mail\MessageDeDjidji;
class MessageController extends Controller
{
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
