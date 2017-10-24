<?php

namespace App\Mail;

use App\Survey;
use App\Sample;
use App\Subject;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SurveyInvite extends Mailable
{
    use Queueable, SerializesModels;

    public $survey, $sample, $sujeito, $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Survey $survey, Sample $sample, Subject $subject)
    {
        $this->survey = $survey;
        $this->sample = $sample;
        $this->sujeito = $subject;
        $this->token = base64_encode(json_encode([
            'survey_id'=>$survey->id,
            'sample_id'=>$sample->id,
            'subject_id'=>$subject->id,
        ]));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Convite')
        ->bcc('alcirsimoes@gmail.com')
        ->markdown('emails.survey.invite');
    }
}
