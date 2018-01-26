<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramUser extends Model
{
	protected $dates = ['expires'];
	protected $hidden = [
		'password'
	];
    protected $fillable = [
        'program_id', 'username', 'password', 'expires', 'special', 'email', 'created_id', 'updated_id'
    ];
    public function program()
    {
    	return $this->belongsTo(Program::class);
    }

    public function fields()
    {
    	return $this->hasMany(UserField::class);
    }
}
