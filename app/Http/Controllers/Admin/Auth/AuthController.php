<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

	private $folder = "admin.";
	private $routeprefix = "admin.";

	public function showLogin()
	{
		return view($this->folder.'login',[
			'form_url' => route($this->routeprefix.'login'),
		]);
	}

	public function login(Request $request)
	{
		
		$validate = Validator::make($request->all(), [
			'email' => 'required|email',
			'password' => 'required'
		],
		[
			'email.exists' => "Email is not exists.",
			'email.required' => 'The Email is required.',
			'email.email' => 'Please enter valid email.',
		]);
		
		if($validate->fails()){
			return Redirect()->back()->with([
								'status'=>false,
								'errors'=>$validate->errors()
							]);
		}
		
		if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
			$request->session()->regenerate();
			return redirect()->route('admin.dashboard');
		}elseif(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
			return redirect()->route('user.leave.index');
		}
		return Redirect()->back()->withErrors(['errors'=>"Password doesn't match,Please try again."]);
	}

	public function logout(Request $request)
	{
		Auth::guard()->logout();
		return redirect()->route($this->routeprefix.'login')->withErrors(['msg'=>'Logout Successfuly.']);
	}
}
