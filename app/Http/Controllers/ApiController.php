<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Program;
use App\License;
use App\ProgramUser;
use App\UserField;
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
        if($this->verifyJWT(request()->header('jwt')))
        {
            $this->validate(request(), [
                'username' => 'required',
                'password' => 'required',
            ]);

            $user1 = ProgramUser::where('username', request('username'))->where('program_id', $this->getIdFromClaim(request()->header('jwt')))->get();
            if(count($user1) > 0) 
            {
                $user = ProgramUser::where('username', request('username'))->where('program_id', $this->getIdFromClaim(request()->header('jwt')))->get()[0];
                if(\Hash::check(request('password'), $user->password))
                {
                    $expires = new \Carbon\Carbon($user->expires);
                    $current = \Carbon\Carbon::now();
                    $diff = $current->diffInSeconds($expires);
                    if($diff <= 0) {
                        $user->expired = 1;
                    } else {
                        $user->expired = 0;
                    }
                    return json_encode(array("jwt" => $this->generateShortTerm($user->id, $user->username, $user->program_id), "user" => $user));
                } 
                else 
                {
                    if(sha1(request('password') == $user->password)) 
                    {
                        $newpass = \Hash::make(request('password'));
                        $user -> password = $newpass;
                        $user -> save();
                        return json_encode(array("jwt" => $this->generateShortTerm($user->id, $user->username, $user->program_id), "user" => $user));
                    } 
                    else 
                    {
                        return json_encode(array("error" => "invalid_info"));
                    }
                }
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
                'expires' => \Carbon\Carbon::now()->addWeeks($this->_grabLicense(request('license'), request()->header('jwt'))[0]->expires),
                'special' => $this->_grabLicense(request('license'), request()->header('jwt'))[0]->special,
            ]);

            $license = License::where('code', request('license'))->where('program_id', $this->getIdFromClaim(request()->header('jwt')))->where('used', 0)->first();
            $license->used = 1;
            $license->save();
            return json_encode(array("success" => true));
        } catch (\Exception $ex) {
            return json_encode(array("success" => false, "error" => "invalid_license"));
        }
    }

    public function grabUser()
    {
        if($this->verifyJWT(request()->header('jwt'))) 
        {
    	   $user = ProgramUser::where('id', $this->getUserIdFromClaim(request()->header('jwt')))->where('program_id', $this->getIdFromClaim(request()->header('jwt')))->get()[0]->toJson();
    	   return $user;
        }
        else 
        {    
            return json_encode(array("success" => false, "info" => "Sam!_That_is_not_ruby!"));
        }
    }

    public function getFields($user_id) 
    {
        if($this->verifyJWT(request()->header('jwt'))) 
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
        if($this->verifyJWT(request()->header('jwt'))) 
        {
           $userfield = ProgramUser::where('id', $user_id)->where('program_id', $this->getIdFromClaim(request()->header('jwt')))->get()[0]->fields()->where('field_name', $field_name)->get()->toJson();
           echo $userfield;
        }
        else 
        {    
            return json_encode(array("success" => false, "info" => "Sam!_That_is_not_ruby!"));
        }
    }

    public function setField($user_id, $field_name) 
    {
        $field_value = request('field_value');
        if($this->verifyJWT(request()->header('jwt'))) 
        {
            $userfield = ProgramUser::where('id', $user_id)->where('program_id', $this->getIdFromClaim(request()->header('jwt')))->get()[0]->fields()->where('field_name', $field_name)->get();
            if($userfield->count() > 0)
            {
                $userfield->field_value = $field_value;
            }
            else
            {
                $newfield = UserField::create([
                    'program_user_id' => $user_id,
                    '' => $this->getIdFromClaim(request()->header('jwt')),
                    'field_name' => $field_name,
                    'field_value' => $field_value,
                    'encrypted' => false
                ]);
            }
            return json_encode(array("status" => "ok"));
        }
        else 
        {    
            return json_encode(array("success" => false, "info" => "Sam!_That_is_not_ruby!"));
        }
    }

    public function grabLicense($license_id)
    {
        if($this->verifyJWT(request()->header('jwt'))) 
        {
    	   $license = License::where('id', $license_id)->where('program_id', $this->getIdFromClaim(request()->header('jwt')))->where('used', 0)->get()->toJson();
    	   echo $license;
        }
        else 
        {    
            return json_encode(array("success" => false, "info" => "Sam!_That_is_not_ruby!"));
        }
    }

    private function _grabLicense($license, $token) 
    {
        if($this->verifyJWT($token)) 
        {
           $license = License::where('code', $license)->where('program_id', $this->getIdFromClaim($token))->where('used', 0)->get();
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
        if($this->verifyJWT(request()->header('jwt'))) 
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
        if($program->count() > 0 && $program->suspended === false) {
            $token = new \Emarref\Jwt\Token();
            $token->addClaim(new Claim\PrivateClaim('name', $program[0]->name));
            $token->addClaim(new Claim\PrivateClaim('program_id', $program[0]->id));
            //Basic Claims
            $token->addClaim(new Claim\Expiration(new \DateTime('2 Hours')));
            $token->addClaim(new Claim\Issuer('authed_io'));
            $token->addClaim(new Claim\IssuedAt(new \DateTime('now')));

            $jwt = new Jwt\Jwt();
            $algorithm = new Algorithm\Hs256('n9w@@&Hat7c$Ws62w3xwU4GD');
            $encryption = Encryption\Factory::create($algorithm);
            $serializedToken = $jwt->serialize($token, $encryption);
            echo $serializedToken;
        } else {
            return json_encode(array("success" => false, "info" => "Sam!_That_is_not_ruby!"));
        }
    }

    public function generateShortTerm($user_id, $username, $program_id) 
    {
        $token = new \Emarref\Jwt\Token();
        $token->addClaim(new Claim\PrivateClaim('name', $username));
        $token->addClaim(new Claim\PrivateClaim('user_id', $user_id));
        $token->addClaim(new Claim\PrivateClaim('program_id', $program_id));
        //Basic Claims
        $token->addClaim(new Claim\Expiration(new \DateTime('30 Seconds')));
        $token->addClaim(new Claim\Issuer('authed_io'));
        $token->addClaim(new Claim\IssuedAt(new \DateTime('now')));

        $jwt = new Jwt\Jwt();
        $algorithm = new Algorithm\Hs256('n9w@@&Hat7c$Ws62w3xwU4GD');
        $encryption = Encryption\Factory::create($algorithm);
        $serializedToken = $jwt->serialize($token, $encryption);
        return $serializedToken;
    }

    public function check()
    {
        if($this->verifyJWT(request()->header('jwt'))) 
        {
            if($this->verifyJWT(request('token'))) {
                $username = $this->getNameFromClaim(request('token'));
                $user_id = $this->getUserIdFromClaim(request('token'));
                $program = $this->getIdFromClaim(request('token'));
                return json_encode(array("success" => true, "info" => "Sam!_That_is_actually_ruby!", "jwt" => $this->generateShortTerm($user_id, $username,$program)));
            } else {
                return json_encode(array("success" => false, "info" => "Sam!_That_is_not_ruby!"));
            }
        } 
        else 
        {    
            return json_encode(array("success" => false, "info" => "Sam!_That_is_not_ruby!"));
        }
    }   

    public function verifyJWT($token)
    {
        try 
        {
            $algorithm = new Algorithm\Hs256('n9w@@&Hat7c$Ws62w3xwU4GD');
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
        catch (\Emarref\Jwt\Exception\ExpiredException $eex)
        {
            $expired = new \Carbon\Carbon($eex->expiredAt->format(DATE_ISO8601));
            $current = \Carbon\Carbon::now();
            $diff = $current->diffInSeconds($expired);
            if($diff < 5) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function getIdFromClaim($token) 
    {
        $algorithm = new Algorithm\Hs256('n9w@@&Hat7c$Ws62w3xwU4GD');
        $encryption = Encryption\Factory::create($algorithm);
        $jwt = new Jwt\Jwt();

        $token = $jwt->deserialize($token);
        return $token->payload->findClaimByName("program_id")->getValue();
    }

    public function getUserIdFromClaim($token) 
    {
        $algorithm = new Algorithm\Hs256('n9w@@&Hat7c$Ws62w3xwU4GD');
        $encryption = Encryption\Factory::create($algorithm);
        $jwt = new Jwt\Jwt();

        $token = $jwt->deserialize($token);
        return $token->payload->findClaimByName("user_id")->getValue();
    }

    public function getNameFromClaim($token) 
    {
        $algorithm = new Algorithm\Hs256('n9w@@&Hat7c$Ws62w3xwU4GD');
        $encryption = Encryption\Factory::create($algorithm);
        $jwt = new Jwt\Jwt();

        $token = $jwt->deserialize($token);
        return $token->payload->findClaimByName("name")->getValue();
    }

}
