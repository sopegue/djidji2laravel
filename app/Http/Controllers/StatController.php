<?php

namespace App\Http\Controllers;

use App\AdDel;
use App\AdMess;
use App\Adresse;
use App\Annonce;
use App\AnnonceAjoute;
use App\AnnonceSaved;
use App\Contact;
use App\ContactUs;
use App\Message;
use App\Seen;
use App\Signaler;
use App\User;
use App\Utilisateur;
use App\Verification;
use App\Visit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class StatController extends Controller
{
    public function index()
    {
        $stat["saved"]=AnnonceSaved::all()->count();
        $stat["added"]=Annonce::all()->count();
        $stat["reported"]=Signaler::whereNotNull('ann_id')->get()->count();
        $stat["deleted"]=AdDel::all()->count();

        $stat["comptes"]=User::where('type','particulier')->get()->count();
        $stat["message"]=Message::all()->count();
        $stat["usReported"]=Signaler::whereNotNull('use_to_sig')->get()->count();
        $visit=Visit::find(1);
        $stat["visiteurs"]=$visit->nb;

        return response($stat, Response::HTTP_OK);
    }
}
