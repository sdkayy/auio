<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProgramUserController extends Controller
{
	/*
		Program User Registration
	*/
    public function store()
    {

    }

	public function delete($program_id, $user_id)
    {
        if($licenses = auth()->user()->programs()->find($program_id)->programUsers()->find($user_id)->delete())
            return back();
        else
            return back()->withErros([
                'Something went wrong! Please try again'
            ]);
    }
}
