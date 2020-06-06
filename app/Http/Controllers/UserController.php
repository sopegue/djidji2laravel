<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Http\UploadedFile;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user=User::where('email',$request->input('email'))->first();
        return response($user->jsonSerialize(), Response::HTTP_OK);
    }

    public function tStore(Request $request)
    {
        $user=User::where('email',$request->input('email'))->first();
        $user->token=$request->input('token');
        $user->save();
        return response($user->jsonSerialize(), Response::HTTP_OK);
    }
    public function checkToken(Request $request)
    {
        $user=User::where('token',$request->input('token'))->first();
        return response($user->jsonSerialize(), Response::HTTP_OK);
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
        //$user=new User();
        $user=User::findOrFail(1);
        //
        $file = $request->file('file');
        //
        $filename = $request->file('file')->getClientOriginalName();
        $user->pp=$filename;
        //$file->store('images/profile/', ['disk' => 'public']);
        $request->file('file')->storeAs(
            '/images/profile/',$filename);
        $user->save();
        return response(null, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        
        $users = User::findOrFail($user);
        if($users==null)
            return response(null, Response::HTTP_OK);
        return response($users->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $user)
    {
        $user = User::findOrFail(Auth::user()->id);
        /* donner les champs de l'anonnce ajouté a modifier */
        $user->save();

        return response($user->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        User::destroy($user);
        return response(null, Response::HTTP_OK);
    }
}
