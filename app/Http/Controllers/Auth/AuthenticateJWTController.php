<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthenticateJWTController extends Controller
{
	public function __construct()
	{
		$this->middleware('jwt.auth', ['except'=>['authenticate']]);
	}

	/**
	* Display a listing of the resource
	*
	* @return \Illuminate\Http\Response
	*/
	public function index()
	{
		return "Auth index";
	}

	public function authenticate(Request $request)
	{
		$credentials = $request->only('id','password');

		try {
			// verify the credentials and create a token for the user
			if (!$token = JWTAuth::attempt($credentials)) {
				return response()->json(['error'=>'invalid_credentials'], 401);
			}
			
		} catch (JWTException $e) {
			//something went wrong
			return response()->json(['error'=>'could_not_create_token'], 500);
		}
		$user  = User::where('id',$request->input('id'))->first();
		return response()->json(['error'=>false,'token'=>$token,'id'=>$user->id,'name'=>$user->name,'email'=>$user->email,'branch'=>$user->branch_id,'department'=>$user->department_id,'position'=>$user->position_id,'role'=>$user->roles()->first()->name]);
	}

	public function getAuthenticatedUser()
	{
		try {
			if (!$user = JWTAuth::parseToken()->authenticate()) {
				return response()->json(['user_not_found'], 404);
			}
		} catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
			return response()->json(['token_expired'], $e->getStatusCode());
		}catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
			return respone()->json(['token_invalid'], $e->getStatusCode());
		}catch (Tymon\JWTAuth\Exceptions\JWTException $e){
			return response()->json(['token_absent'], $e->getStatusCode());
		}

		// th token is valid 
		return response()->json(compact('user'));
	}
}
