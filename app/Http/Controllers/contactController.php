<?php

namespace App\Http\Controllers;

use App;
use App\contact;
use App\Mail\contactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
class contactController extends Controller
{
    public function index(Request $request){
        $data=[

            'nom' => $request->firstname,

            'prenom' => $request->lastname,
            'pays' => $request->country,
            'sujet' => $request->subject

        ];
        Mail::to('yayasopeguesoro@gmail.com')
            ->send(new contactMail($request));
        return view('contact');
    }
}
