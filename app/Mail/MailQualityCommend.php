<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailQualityCommend extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($dat)
    {
        $this->data = $dat;
    }

    public function build()
    {

        return $this->view('pages.qualities.mail_client')
            ->subject( 'GreenCenter Recomendaciones')

            ->attach( $this->data['patch'], [
                'as' =>  $this->data['namepdf'],
                'mime' => $this->data['mime'],
            ]);
    }
}
