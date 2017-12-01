<?php

namespace App\Mail;

use App\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $newsletter;
    private $userid;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Newsletter $news, $id)
    {
        $this->newsletter           = $news;
        $this->userid               = $id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('newsletter@emoonastudio.com', 'Emoona Studio')
                    ->subject($this->newsletter->title)
                    ->markdown('emails.newsletter')
                    ->with('userid', $this->userid);
    }
}
