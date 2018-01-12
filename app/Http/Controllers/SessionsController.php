<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
    protected $redirectTo = '/dashboard';
    protected $redirectPath = '/dashboard';

    public function __construct()
    {
    	$this->middleware('guest')->except(['destroy']);
    }

    public function index()
    {
    	return view('sessions.create');
    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/');
    }

    public function store()
    {
    	if(!auth()->attempt(request(['username', 'password']))) {
    		return back()->withErrors([
    			'Error verifying your credentials'
    		]);
    	}

    	return redirect('home');
    }
}
