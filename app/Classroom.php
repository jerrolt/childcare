<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
	
	public function facility()
    {
		return $this->belongsTo(Facility::class);
    }
    /*
    public function facility()
    {
		return $this->hasOne(Facility::class);
    }
    */
    public function students()
    {
		return $this->hasMany(Student::class);
    }
}
