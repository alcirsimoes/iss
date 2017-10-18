<?php

namespace App\Mail;

use App\Survey;
use App\Subject;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SurveyInvite extends Mailable
{
    use Queueable, SerializesModels;

    public $survey, $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Survey $survey, Subject $subject)
    {
        $this->survey = $survey;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.survey.invite');
    }
}
