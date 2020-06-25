<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use App\Annonce;
use Illuminate\Http\Response;
class Contact_usController extends Controller
{
    public function contact(Request $request)
    {
        $mess=new Contact();
        if($request->has('user')){
            $mess->use_id=$request->input('user');
        }
        $mess->mail=$request->input('email');
        $mess->name=$request->input('name');
        $mess->subject=$request->input('subject');
        $mess->content=$request->input('message');

        $mess->save();
        return response(null, Response::HTTP_OK);

    }
}
