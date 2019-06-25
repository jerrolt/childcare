<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timecard extends Model
{
    //
    public $timestamps = false;
    
    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }
    
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    
	public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
    
    public function timecard_changes()
    {
	    return $this->hasMany(TimecardChange::class);
    }
}
