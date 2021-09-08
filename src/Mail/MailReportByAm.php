<?php

namespace Aungmyat\Report\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailReportByAm extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected  $filename;
    public  $subject;
    public function __construct($filename,$subject)
    {
        $this->filename = $filename;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('report::mailtem')
                     ->attach(storage_path('app/'.$this->filename))
                     ->subject($this->subject);

    }
}
