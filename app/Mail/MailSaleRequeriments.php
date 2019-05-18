<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailSaleRequeriments extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($dat)
    {
        $this->data = $dat;
    }

    public function build()
    {

        return $this->view('pages.sales.mail_requirements')
            ->subject( 'GreenCenter Requerimientos Nota No: ' . $this->data['sale']['id'])

            ->attach( $this->data['patch'], [
                'as' =>  $this->data['namepdf'],
                'mime' => 'application/pdf',
            ]);
    }
}
