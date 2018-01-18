<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{

	public function __construct()
	{
		$this->middleware('guest');
	}

    public function index() 
    {
    	return view('registration.create');
    }

    public function store()
    {
    	$this->validate(request(),[
    		'username' => 'required',
    		'password' => 'required|confirmed',
    		'email' => 'required|email',
            'g-recaptcha-response' => 'required|recaptcha'
    	]);

    	$user = User::create([
    		'username' => request('username'),
    		'email' => request('email'),
    		'password' => bcrypt(request('password')),
    		'subscription' => 0
    	]);

    	auth()->login($user);

    	return redirect('home');
    }
}
