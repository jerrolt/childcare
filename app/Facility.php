<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
	
	/**
	 *	scopeIgnoreDeleted
	 *
	 */
    public function scopeIgnoreDeleted($query)
	{
	    return $query->where('deleted_at', '=', null);
	}
	
	/**
	 *	scopeIgnoreDeleted
	 *
	 */	
	public function classrooms()
    {
		return $this->hasMany(Classroom::class);
    }
    
    
    public function students()
    {
		return $this->hasMany(Student::class);
    }
    
    public function carrier()
    {
		return $this->belongsTo(Carrier::class);
    }
    
    public function timecards()
    {
	    return $this->belongsTo(Timecard::class);
    }
    
}
