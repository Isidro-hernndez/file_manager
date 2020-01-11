<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //

	public function folder()
	{
		return $this->belongsTo(Folder::class);
	}

	public function user()
	{
		return $this->hasOneThrough('App\Folder', 'App\User');
	}
}
