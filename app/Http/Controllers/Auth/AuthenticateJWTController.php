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

		$user = User::where('id', $request->input('id'))
				->where('is_user', true)
				->first();

		$user['role'] = $user->roles()->first()->name;
		$user['token_jwt'] = $token;

		if (!$user) {
			return response()->json([
				'error'=>[
					'message'=>'User does not exist'
				]
			], 404);
		}

		return response()->json(
			$this->transform($user)
		);
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

	public function transform($user)
	{
		return [
			'nik'=>$user['id'],
			'name'=>$user['name'],
			"alias"=> $user['alias'],
			"email"=> $user['email'],
			"address"=> $user['address'],
			"city"=> $user['city'],
			"birthday"=>$user['birthday'],
			"birthplace"=>$user['birthplace'],
			"phone"=>$user['phone'],
			"marrital"=>$user['marrital'],
			"blood_type"=> $user['blood_type'],
			"zipcode"=> $user['zipcode'],
			"gender"=> $user['gender'],
			"bank_account"=>$user['bank_account'],
			"npwp"=>$user['npwp'],
			"bank_branch"=>$user['bank_branch'],
			"bank_name"=>$user['bank_name'],
			"job_status"=>$user['job_status'],
			"job_start"=>$user['job_start'],
			"branch_id"=>$user['branch_id'],
			"company_id"=>$user['company_id'],
			"department_id"=>$user['department_id'],
			"position_id"=>$user['position_id'],
			"grade"=>$user['grade'],
			"mother_name"=>$user['mother_name'],
			"pic_id"=>$user['pic_id'],
			"is_user"=>$user['is_user'],
			"role"=>$user['role'],
			"token"=>$user['token_jwt']
		];
	}
}
