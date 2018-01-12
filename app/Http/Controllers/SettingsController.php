<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function index()
    {
    	return view('settings.index');
    }

    public function update()
    {
    	$this->validate(request(),[
    		'new_email' => 'email|required',
    		'new_password' => 'confirmed'
    	]);

    	$new_email		= request('new_email');
    	$new_password	= bcrypt(request('new_password'));

    	if(auth()->user()->email != $new_email) {
    		auth()->user()->email = $new_email;
    		auth()->user()->save();
    	}

    	return back();
    }
}
