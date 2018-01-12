<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Program;

class ProgramController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function index($id)
    {
        $program = auth()
                    ->user()
                    ->programs()
                    ->find($id);

        $pusers = $program
                    ->programUsers()
                    ->simplePaginate(10, ['*'], 'users');

        $licenses = $program
                    ->licenses()
                    ->orderByRaw('id desc')
                    ->simplePaginate(10, ['*'], 'licenses');

        return view('programs.index', compact(['pusers', 'licenses', 'id']));
    }

    public function store()
    {
    	$this->validate(request(), [
    		'name' => 'required'
    	]);

        auth()->user()->addProgram(
            new Program(['name' => request('name'), 'secret' => str_random(45)])
        );

    	return redirect('/home');
    }
}
