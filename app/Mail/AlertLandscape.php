<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AlertLandscape extends Mailable
{
    use Queueable, SerializesModels;


    public $data;

    public function __construct($dat)
    {
       $this->data = $dat;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('pages.cags.mail_landscaper')
            ->subject( 'Alerta de Vista a domicilio');
    }
}
