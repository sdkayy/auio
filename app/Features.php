<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Program;

class Features extends Model
{
    public function program() {
    	return $this->belongsTo(Program::class);
    }
}
