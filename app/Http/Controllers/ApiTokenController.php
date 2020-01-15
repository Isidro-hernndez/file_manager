<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\CreateUserApiRequest;

class ApiTokenController extends Controller
{
	public function register(CreateUserApiRequest $request){
		$status = true;
		$desc = 'Usuario registrado';
		// return response()->json($request);
		$token = Str::random(60);

		$user = User::create([
			'name' => $request->name,
			'last_name' => $request->last_name,
			'email' => $request->email,
			'password' => Hash::make($request->password),
			'api_token' => hash('sha256', $token),
		]);
		$user->forceFill([
			'api_token' => hash('sha256', $token),
		])->save();
		return response()->json([
			'user' => $user,
			'status' => $status,
			'desc' => $desc
		]);
	}
	public function update(Request $request)
	{
		$credentials = $request->only('email', 'password');
		$email = $request->email;
		$user = null;
		$status = 'error';
		$desc = 'Error de acceso';
		if (Auth::attempt($credentials)) {
			// Authentication passed...
			$user = User::where('email', $email)->get()->first();
			// dd($user);

			$token = Str::random(60);


			// dd($user);
			// $request->user()->forceFill([
			//     'api_token' => hash('sha256', $token),
			// ])->save();
			$user->forceFill([
				'api_token' => hash('sha256', $token),
			])->save();
			$auth = Auth::guard('api');
			$auth = Auth::login($user);
			$user = Auth::user();
			$status = 'success';
			$desc = 'Usuario loggeado';

		}
		return response()->json([
			'user' => $user,
			'status' => $status,
			'desc' => $desc
		]);

	}
	public function logout(Request $request){
		$user = Auth::user();
		$status = 'error';
		$desc = 'problema al cerrar sesión';
		if($user){
			// $this->guard()->logout();
			// dd($request);
			// return response()->json(['user' => $user->session()]);
			// $request->session()->invalidate();
			$user->forceFill([
				'api_token' => $token = Str::random(60),
			])->save();
			// $user = Auth::logout();
			// dd($user);
			$status = 'success';
			$desc = 'Usuario desloggeado';
			// $user = LoginController::logout();
		}
		return response()->json([
			'user' => $user,
			'status' => $status,
			'desc' => $desc
		]);
	}
}
