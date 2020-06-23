<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CourseConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $company;
    public $course;
    public $request;

    /**
     * Create a new message instance.
     *
     * @param $company
     * @param $course
     * @param $request
     */
    public function __construct($company, $course, $request)
    {
        $this->company = $company;
        $this->course = $course;
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.course-confirmation')
            ->from(env('MAIL_FROM_ADDRESS'), $this->company->email)
            ->replyTo($this->company->email)
            ->subject(__('course booking confirmation'));
    }
}
