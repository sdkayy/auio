<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProgramUser;

class UserField extends Model
{
    public function user()
    {
    	return $this->belongsTo(ProgramUser::class);	
    }
}
