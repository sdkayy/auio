<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class DashboardController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	
    public function index()
    {
    	$programs = auth()->user()->programs()->get();
        
    	return view('dashboard.index', compact('programs'));
    }

    public function download()
	{
    	return view('dashboard.download');
    }
}
