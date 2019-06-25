<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
	
    /**
     * Load all Guardians of a Student
     *
     * @return Guardian::class
     */
    public function guardians()
    {
	    return $this->belongsToMany(Guardian::class);
    }
        
    /**
     * Load the primary_guardian of a Student
     *
     * @return Guardian::class
     */  
    public function primary_guardian()
    {
	    return $this->belongsTo(Guardian::class, 'primary_guardian_id');
    }
    
    /**
     * Load the students' classroom
     *
     * @return Classroom::class
     */     
    public function classroom()
    {
	    return $this->belongsTo(Classroom::class);
    }
    
    /**
     * Load the students Facility
     *
     * @return Facility::class
     */    
    public function facility()
    {
	    return $this->belongsTo(Facility::class);
    }
    
    public function timecards()
    {   
    	return $this->hasMany(Timecard::class);
    }
}
