<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailMaintananceCommend extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($dat)
    {
        $this->data = $dat;
    }

    public function build()
    {

        return $this->view('pages.maintenances.mail')
            ->subject( 'GreenCenter Recomendaciones')

            ->attach( $this->data['patch'], [
                'as' =>  $this->data['namepdf'],
                'mime' => $this->data['mime'],
            ]);
    }
}
