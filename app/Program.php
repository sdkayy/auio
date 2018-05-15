<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Program extends Model
{
	protected $fillable = [
        'user_id', 'name', 'secret', 'suspended', 'requires_auth', 'banned', 'has_migrated'
    ];

    protected $hidden = [
    	'secret'
    ];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function features() {
		return $this->hasMany(Features::class);
	}

	public function programUsers()
	{
		return $this->hasMany(ProgramUser::class);
	}

	public function licenses()
	{
		return $this->hasMany(License::class);
	}
}
