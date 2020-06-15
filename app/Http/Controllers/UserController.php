<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function pwdUpdate(Request $request)
    {
        $id=$request->input('user');
        $user=User::find($id);
        $isModified=0;
        $currentpwd=$request->input('pwd');
        $newpwd=$request->input('newpwd');
        if (Hash::check($currentpwd, $user->password))
        {
            $isModified=2;
            $user->password = Hash::make($newpwd);
            // The passwords match...
        }
        $user->save();
        return $isModified;
    }
    public function updateUser(Request $request)
    {
        $user=User::find($request->input('user'));
        $count=User::where('email',$request->input('email'))->count();
        if($user->email==$request->input('email'))
        {
            //$user->email=$request->input('email');
            $user->Nom=$request->input('name');
            $user->Prenom=$request->input('surname');
            $user->ville=$request->input('ville');
            $user->tel=$request->input('tel');
        }
        else{
            $user->email=$request->input('email');
            $user->Nom=$request->input('name');
            $user->Prenom=$request->input('surname');
            $user->ville=$request->input('ville');
            $user->tel=$request->input('tel');
        }
        $user->save();
        return response(null, Response::HTTP_OK);
    }
    public function checkExistance(Request $request){
        $count=User::where('email',$request->input('email'))->count();
        return $count;
    }
    public function checkExistanceUpdate(Request $request){
       
        $user=User::find($request->input('user'));
        $count=User::where('email',$request->input('email'))->count();
        if($user->email==$request->input('email'))
            $count=0;
        return $count;
    }
    public function updatePic(Request $request)
    {
        $id=$request->input('user');
        $user=User::find($id);
        $oldpic=$user->pp;
        Storage::disk('public')->delete($id.'//profile/'.$oldpic);
        $mypic=$request->file('file');
        $extension=$mypic->getClientOriginalExtension();
        $pp="user.{$extension}";
        $mypic->storeAs('public/'.$id.'//profile/',$pp);
        $user->pp=$pp;
        $user->save();
        return response(null, Response::HTTP_OK);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user=User::where(['email'=>$request->input('email'),'email'=>$request->input('email')])->first();
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

    public function vUser($id)
    {
        $users = User::find($id);
        if($users==null)
            return response(null, Response::HTTP_OK);
        return response($users->jsonSerialize(), Response::HTTP_OK);
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
