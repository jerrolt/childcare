<?php

namespace App\Mail;

use App\Timecard;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class StudentPickup extends Mailable
{
    use Queueable, SerializesModels;

	protected $timecard;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Timecard $timecard)
    {
    	$this->timecard = $timecard;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
$date = date('D, M j, Y', strtotime($this->timecard->action_at));
	    $time = date('h:m A', strtotime($this->timecard->action_at));
	    $child = ucfirst(strtolower($this->timecard->student->firstname)) . ' ' . ucfirst(strtolower($this->timecard->student->lastname));
	    $guardian = ucwords(strtolower($this->timecard->guardian->firstname) . ' ' . strtolower($this->timecard->guardian->lastname));
	    $facility = ucwords(strtolower($this->timecard->facility->name));
	    
        return $this->subject('Child Pick Up')->view('emails.student.pickup')->text('emails.student.pickup')->with([
	        'date'     => $date,
	        'time'     => $time,
	        'child'    => $child,
	        'guardian' => $guardian,
	        'facility' => $facility
        ]);
    }
}
