<?php
/**
 * Created by PhpStorm.
 * User: papitoff
 * Date: 18/05/19
 * Time: 11:11 AM
 */

namespace App\Entities;


use App\Models\LandScaper;
use App\Models\Quotes\Quote;
use App\Models\SalesNotes\SalesNote;

class NotificationDaily
{
    protected $id;
    protected $position;
    
    public function __construct($id, $position)
    {
      $this->id = $id;
      $this->position = $position;
    }

    protected function Notifications() {
        // VISITAS A DOMICILIO
        $landscapers = LandScaper::query()->with(['user', 'global' => function($q) {
            $q->with('client', 'quote');
        }])->leftJoin('cglobals', 'cglobals.id',   'landscapers.cglobal_id')
            ->whereRaw('DATEDIFF(now(), landscapers.moment) >= 0')
            ->where('landscapers.status_id',  0);

        if ( $this->position !== 1) {
            $landscapers =  $landscapers->where('cglobals.user_id', $this->id)
                ->select('landscapers.*')->get();
        } else {
            $landscapers =  $landscapers->select('landscapers.*')->get();
        }

        // CONFIRMACION DE COTIZACIONES
        $quote_confirm = Quote::with(['globals' => function($q) {
            $q->with('client');
        }])->leftJoin('cglobals', 'cglobals.id',   'quotes.cglobal_id')
            ->whereRaw('DATEDIFF(now(), quotes.check_date ) > 1')
            ->where('quotes.status_id', 3); // CONFIRMACION

        if ( $this->position !== 1) {
            $quote_confirm = $quote_confirm->where('cglobals.user_id', $this->id)
                ->select('quotes.*')->get();
        } else {
            $quote_confirm = $quote_confirm->select('quotes.*')->get();
        }

        // SEGUIMIENTO DE COTIZACIONES
        $quote_tracing = Quote::with(['globals' => function($q) {
            $q->with('client');
        }])->leftJoin('cglobals', 'cglobals.id',   'quotes.cglobal_id')
            ->whereRaw('DATEDIFF(now(), quotes.check_date ) >= 0')
            ->where('quotes.status_id', 7); // SEGUIMIENTO
        if ( $this->position !== 1) {
            $quote_tracing = $quote_tracing->where('cglobals.user_id', $this->id)
                ->select('quotes.*')->get();
        } else {
            $quote_tracing = $quote_tracing->select('quotes.*')->get();
        }

        // NOTA CREADA SIN CONTENIDO
        $salen_note_not_close = SalesNote::query()->with(['globals' => function($q) {
            $q->with('client', 'user');
        }])->leftJoin('cglobals', 'cglobals.id',   'salesnotes.global_id')
            ->whereRaw('DATEDIFF(now() , salesnotes.moment) >= 0')
            ->where('salesnotes.status_id', 3);
        if ( $this->position !== 1) {
            $salen_note_not_close =  $salen_note_not_close->where('cglobals.user_id', $this->id)
                ->select('salesnotes.*' )->get();
        } else {
            $salen_note_not_close =  $salen_note_not_close->select('salesnotes.*')->get();
        }

        // COTIZACION A DISTANCIA  CREADA SIN CONTENIDO
        $quote_local_close = Quote::query()->with(['globals' => function($q) {
            $q->with('client', 'user');
        }])->leftJoin('cglobals', 'cglobals.id',   'quotes.cglobal_id')
            ->whereRaw('DATEDIFF(now(), quotes.moment) >= 0')
            ->where('quotes.status_id', 2)
            ->where('quotes.type_quote_id', 2);
        if ( $this->position !== 1) {
            $quote_local_close =  $quote_local_close->where('cglobals.user_id', $this->id)
                ->select('quotes.*' )->get();
        } else {
            $quote_local_close = $quote_local_close->select('quotes.*')->get();
        }

        // GESTION DE COBRANZA
        $sale_note_not_payment = SalesNote::query()->with(['globals' => function($q) {
            $q->with('client', 'user');
        }])->leftJoin('cglobals', 'cglobals.id',   'salesnotes.global_id')
            ->whereRaw('DATEDIFF(now() , salesnotes.paimentdate) >= 0')
            ->wherein('salesnotes.status_id', [1, 4, 6, 8]);
        if ( $this->position !== 1) {
            $sale_note_not_payment  =   $sale_note_not_payment ->where('cglobals.user_id', $this->id)
                ->select('salesnotes.*' )->get();
        } else {
            $sale_note_not_payment  =   $sale_note_not_payment ->select('salesnotes.*')->get();
        }

        // INSTALACION O ENGREAGA DE TRABAJOS
        $sale_note_not_delivered = SalesNote::query()->with(['globals' => function($q) {
            $q->with('client', 'user');
        }])->leftJoin('cglobals', 'cglobals.id',   'salesnotes.global_id')
            ->whereRaw('DATEDIFF(now() , salesnotes.deliverydate) >= 0')
            ->wherein('salesnotes.status_id', [ 4, 5, 6]);
        if ( $this->position !== 1) {
            $sale_note_not_delivered = $sale_note_not_delivered->where('cglobals.user_id', $this->id)
                ->select('salesnotes.*' )->get();
        } else {
            $sale_note_not_delivered = $sale_note_not_delivered ->select('salesnotes.*')->get();
        }

        $data = [
            'landscapers' => $landscapers,

            'quoteconfirm' => $quote_confirm,

            'quotetracing' => $quote_tracing,

            'sale_note_not_close' => $salen_note_not_close,

            'quote_local_close' => $quote_local_close,

            'sale_note_not_payment' => $sale_note_not_payment,

            'sale_note_not_delivered' => $sale_note_not_delivered
        ];

        return $data;

    }

    public function exitNotify() {
        $data = $this->Notifications();

        $land = count($data['landscapers']) > 0;
        $quoteconfirm = count($data['quoteconfirm']) > 0;
        $quotetracing= count($data['quotetracing']) > 0;
        $sale_note_not_close= count($data['sale_note_not_close']) > 0;
        $quote_local_close= count($data['quote_local_close']) > 0;
        $sale_note_not_payment= count($data['sale_note_not_payment']) > 0;
        $sale_note_not_delivered = count($data['sale_note_not_delivered']) > 0;

        return $land || $quoteconfirm || $quotetracing || $sale_note_not_close || $quote_local_close
            || $sale_note_not_payment || $sale_note_not_delivered;
    }

    public function Daily() {
       return $this->Notifications();
    }
}
