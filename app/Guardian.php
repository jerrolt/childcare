<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    public function user()
    {
		return $this->belongsTo(User::class);
    }
    
    public function students()
    {
	    return $this->belongsToMany(Student::class);
    }
    
    
    public function primary_guardian_of()
    {
	    return $this->hasMany(Student::class);
    }
    
    public function carrier()
    {
		return $this->belongsTo(Carrier::class);
    }
    
    
    public function timecards()
    {
	    return $this->hasMany(Timecard::class);
    }
    
    public function getMsgAddress()
    {
	    $phone = '';
		for($x=0; $x < strlen($this->phone); $x++)
		{
			if(is_numeric($this->phone[$x]))
			{
				$phone .= $this->phone[$x];
			}										
		}						
		return $phone.'@'.$this->carrier->domain;
    }
}
