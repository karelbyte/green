<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendQuoteClient extends Mailable
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
       // dd($this->data);

        return $this->view('pages.quotes.mail')
            ->subject( 'GreenCenter Cotizacion No: ' . $this->data['data']['id'])

            ->attach( $this->data['patch'], [
                'as' =>  $this->data['namepdf'],
                'mime' => 'application/pdf',
            ]);
    }
}
