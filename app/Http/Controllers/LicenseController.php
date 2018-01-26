<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\License;

class LicenseController extends Controller
{
    public function verify()
    {

    }

    public function store($id)
    {
    	$this->validate(request(), [
    		'license_length' => 'required|max:10',
    		'license_amount' => 'required',
            'license_level' => 'required|max:999'
    	]);

        $prefix             = request('license_prefix') ? request('license_prefix') : '';
    	$license_length 	= request('license_length');
    	$license_amount		= request('license_amount');
        $license_level      = request('license_level');

        $license_amount = ($license_amount > 10 ? 10 : $license_amount);    

        for($i = 0; $i < $license_amount; $i++) {
            $license = License::create([
                'program_id' => $id,
                'code' => ($prefix != '' ? $prefix . '-' . str_random(25 - strlen($prefix)) : str_random(25)),
                'expires' => $license_length,
                'special' => $license_level,
                'used' => 0
            ]);
        }

        return back();
    }

    public function delete($program_id, $license_id)
    {
        if($licenses = auth()->user()->programs()->find($program_id)->licenses()->find($license_id)->delete())
            return back();
        else
            return back()->withErros([
                'Something went wrong! Please try again'
            ]);
    }
}
