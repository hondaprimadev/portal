<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Services\UploadProfileManager;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $manager;

    public function __construct(UploadProfileManager $manager)
    {
        $this->manager = $manager;
    }
    public function index()
    {
    	return view('dashboard.index');
    }

    public function getProfile($token)
    {
    	$user = User::where('token', $token)->first();

    	return view('dashboard.profile.index', compact('user'));
    }

    public function postProfile(Request $request, $token)
    {
        $photo = $request->input('profile_text');
    	$user = User::where('token', $token)->first();
        if($request->input('password')){
            $user->update([
                'alias'=> $request->input('alias'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'password'=>bcrypt($request->input('password'))
            ]);
        }else{
            $user->update([
                'alias'=> $request->input('alias'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
            ]);
        }

        if ($photo) {
            $uploadProfile = $this->manager->uploadProfile($photo,$user->id);   
        }

    	return back();
    }
}
