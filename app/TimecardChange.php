<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TimecardChange extends Model
{
    public function timecard()
    {
        return $this->belongsTo(Timecard::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
