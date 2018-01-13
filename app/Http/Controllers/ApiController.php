<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Program;
use App\License;
use App\ProgramUser;
use Emarref\Jwt;
use Emarref\Jwt\Token;
use Emarref\Jwt\Claim;
use Emarref\Jwt\Algorithm;
use Emarref\Jwt\Encryption;
use Emarref\Jwt\Verification;

class ApiController extends Controller
{
    public function login()
    {
        if($this->verifyJTW(request()->header('jwt')))
        {
            $this->validate(request(), [
                'username' => 'required',
                'password' => 'required',
            ]);

            $user = ProgramUser::where('username', request('username'))->where('program_id', $this->getIdFromClaim(request()->header('jwt')))->first();

            if(\Hash::check(request('password'), $user->password))
            {
                echo $user->get()[0]->toJson();
            } 
            else 
            {
                return json_encode(array("error" => "invalid_info"));
            }
        }
        else
        {
            return json_encode(array("success" => false, "info" => "Sam!_That_is_not_ruby!"));
        }
    }

    public function register()
    {
        try {

            $this->validate(request(), [
                'username' => 'required',
                'password' => 'required',
                'email' => 'required',
                'license' => 'required'     
            ]);

            $user = ProgramUser::create([
                'program_id' => $this->getIdFromClaim(request()->header('jwt')),
                'username' => request('username'),
                'password' => bcrypt(request('password')),
                'email' => request('email'),
                'expires' => \Carbon\Carbon::now()->addWeeks($this->_grabLicense(request('license'), request()->header('jwt'))[0]->expires)
            ]);
            return json_encode(array("success" => true));
        } catch (\Exception $ex) {
            return json_encode(array("success" => false, "error" => "invalid_license"));
        }
    }

    public function grabUser($user_id)
    {
        if($this->verifyJTW(request()->header('jwt'))) 
        {
    	   $user = ProgramUser::where('id', $user_id)->where('program_id', $this->getIdFromClaim(request()->header('jwt')))->get()->toJson();
    	   echo $user;
        }
        else 
        {    
            return json_encode(array("success" => false, "info" => "Sam!_That_is_not_ruby!"));
        }
    }

    public function getFields($user_id) 
    {
        if($this->verifyJTW(request()->header('jwt'))) 
        {
           $userfields = ProgramUser::where('id', $user_id)->where('program_id', $this->getIdFromClaim(request()->header('jwt')))->get()[0]->fields()->get()->toJson();
           echo $userfields;
        }
        else 
        {    
            return json_encode(array("success" => false, "info" => "Sam!_That_is_not_ruby!"));
        }
    }

    public function getField($user_id, $field_name) 
    {
        if($this->verifyJTW(request()->header('jwt'))) 
        {
           $userfield = ProgramUser::where('id', $user_id)->where('program_id', $this->getIdFromClaim(request()->header('jwt')))->get()[0]->fields()->where('field_name', $field_name)->get()->toJson();
           echo $userfield;
        }
        else 
        {    
            return json_encode(array("success" => false, "info" => "Sam!_That_is_not_ruby!"));
        }
    }

    public function grabLicense($license_id)
    {
        if($this->verifyJTW(request()->header('jwt'))) 
        {
    	   $license = License::where('id', $license_id)->where('program_id', $this->getIdFromClaim(request()->header('jwt')))->get()->toJson();
    	   echo $license;
        }
        else 
        {    
            return json_encode(array("success" => false, "info" => "Sam!_That_is_not_ruby!"));
        }
    }

    private function _grabLicense($license, $token) 
    {
        if($this->verifyJTW($token)) 
        {
           $license = License::where('code', $license)->where('program_id', $this->getIdFromClaim($token))->get();
           return $license;
        }
        else 
        {    
            return json_encode(array("success" => false, "info" => "Sam!_That_is_not_ruby!"));
        }
    }

    public function grabProgram($program_id)
    {   
        dd("x");
        if($this->verifyJTW(request()->header('jwt'))) 
        {
    	   $program = Program::find($program_id)->get()->toJson();
		   dd($program);
        } 
        else 
        {    
            return json_encode(array("success" => false, "info" => "Sam!_That_is_not_ruby!"));
        }
    }

    public function authenticate()
    {
        $program = Program::where('secret', request('secret'))->get();
        if($program->count() > 0) {
            $token = new \Emarref\Jwt\Token();
            $token->addClaim(new Claim\PrivateClaim('name', $program[0]->name));
            $token->addClaim(new Claim\PrivateClaim('program_id', $program[0]->id));
            //Basic Claims
            $token->addClaim(new Claim\Expiration(new \DateTime('2 Hours')));
            $token->addClaim(new Claim\Issuer('authed_io'));
            $token->addClaim(new Claim\IssuedAt(new \DateTime('now')));

            $jwt = new Jwt\Jwt();
            $algorithm = new Algorithm\Hs256('authed_io');
            $encryption = Encryption\Factory::create($algorithm);
            $serializedToken = $jwt->serialize($token, $encryption);
            echo $serializedToken;
        } else {
            return json_encode(array("success" => false, "info" => "Sam!_That_is_not_ruby!"));
        }
    }

    public function check()
    {
        if($this->verifyJTW(request()->header('jwt'))) 
        {
            return json_encode(array("success" => true, "info" => "Sam!_That_is_actually_ruby!"));
        } 
        else 
        {    
            return json_encode(array("success" => false, "info" => "Sam!_That_is_not_ruby!"));
        }
    }   

    public function verifyJTW($token)
    {
        try 
        {
            $algorithm = new Algorithm\Hs256('authed_io');
            $encryption = Encryption\Factory::create($algorithm);
            $jwt = new Jwt\Jwt();

            $token = $jwt->deserialize($token);
            $context = new \Emarref\Jwt\Verification\Context($encryption);
            $context->setIssuer('authed_io');
            if($jwt->verify($token, $context))
                return true;
            else
                return false;
        }
        catch (\InvalidArgumentException $ex)
        {
            return false;
        }
    }

    public function getIdFromClaim($token) 
    {
        $algorithm = new Algorithm\Hs256('authed_io');
        $encryption = Encryption\Factory::create($algorithm);
        $jwt = new Jwt\Jwt();

        $token = $jwt->deserialize($token);
        return $token->payload->findClaimByName("program_id")->getValue();
    }

}
