<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Program;
use App\ProgramUser;

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

    public function transfer() 
    {
        $program = auth()
                    ->user()
                    ->programs()
                    ->find(request('program'));
        if($program->has_migrated == false) {
            $url = 'http://api.betterseal.net/usertransfer.php';
        
            $data = array(
                'app_admin_sec' => request('app_admin_sec'), 
                'app_sec' => request('app_sec')
            );
           // dd($data);

            // use key 'http' even if you send the request to https://...
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data)
                )
            );
            $context  = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            if ($result === FALSE) { }

            $json = json_decode($result);
            foreach($json->{'users'} as $user) {
                if($user->expires == "0") {
                    $expires = ;
                } else {
                    $expires = Carbon::createFromTimestamp($user->expires)->toDateTimeString();
                }
                $newUser = ProgramUser::create([
                    "username" => $user->username,
                    "password" => $user->password,
                    "program_id" => request('program'),
                    "special" => $user->level,
                    "expires" => $expires,
                    "email" => $user->username . '@fake.com'
                ]);
            }
            $program -> has_migrated = true;
            return back();
        } else {
            return back();
        }
    }

    public function suspend() {
        $program = auth()->USER()->programs()->find($id);
        $program->suspended = true;
        return back();
    }

    public function store()
    {
    	$this->validate(request(), [
    		'name' => 'required'
    	]);

        auth()->user()->addProgram(
            new Program([
                'name' => request('name'), 
                'secret' => str_random(45), 
                'has_migrated' => false
            ])
        );

    	return redirect('/home');
    }
}
