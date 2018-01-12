<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;

class License extends Model
{
	protected $dates = ['deleted_at'];
	protected $fillable = [ 'program_id', 'code', 'expires', 'special' ];
    public function program()
    {
    	return $this->belongsTo(Program::class);
    }
}
