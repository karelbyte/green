<?php

namespace App\Entities;


use App\Http\Resources\QualitiesSendInfo;
use App\Http\Resources\QualitiesSendInfoConfirm;
use App\Http\Resources\QuoteLocalEmpty;
use App\Http\Resources\QuoteSendConfirm;
use App\Http\Resources\QuoteTracing;
use App\Http\Resources\SalesNoteNotDelivered;
use App\Http\Resources\SalesNoteNotPayment;
use App\Http\Resources\VisitHomeNotification;
use App\Models\LandScaper;
use App\Models\Qualities\Quality;
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

        // VISITAS A DOMICILIO CON OBJETO RECURSO
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
        $landscapers = VisitHomeNotification::collection($landscapers);

        // VERIFICACION DE RECEPCION DE COTIZACION CON OBJETO RESOURCE
        $quote_confirm = Quote::with(['globals' => function($q) {
            $q->with('client');
        }])->leftJoin('cglobals', 'cglobals.id',   'quotes.cglobal_id')
            ->whereRaw('DATEDIFF(now(), quotes.check_date ) > 1')
            ->where('quotes.status_id', 3);
        if ( $this->position !== 1) {
            $quote_confirm = $quote_confirm->where('cglobals.user_id', $this->id)
                ->select('quotes.*')->get();
        } else {
            $quote_confirm = $quote_confirm->select('quotes.*')->get();
        }
        $quote_confirm = QuoteSendConfirm::collection($quote_confirm);

        // OJOOOOOOOOOO FALTA LA ESTRATEGIA DE VENTA



        // SEGUIMIENTO DE COTIZACIONES CON OBJETO RESOURCE
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
        $quote_tracing = QuoteTracing::collection( $quote_tracing);


        // NOTA CREADA SIN CONTENIDO  ---------- OJO REVISAR --------
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

        // COTIZACION A DISTANCIA  CREADA SIN CONTENIDO CON OBJETO RESOURCE
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
        $quote_local_close = QuoteLocalEmpty::collection($quote_local_close);

        // GESTION DE COBRANZA CON OBJETO RESOURCE
        $sale_note_not_payment = SalesNote::query()->with(['globals' => function($q) {
            $q->with('client', 'user');
        }])->leftJoin('cglobals', 'cglobals.id',   'salesnotes.global_id')
            ->whereRaw('DATEDIFF(now() , salesnotes.paimentdate) >= 0')
            ->wherein('salesnotes.status_id', [1, 4, 6, 8]);
        if ( $this->position !== 1) {
            $sale_note_not_payment = $sale_note_not_payment ->where('cglobals.user_id', $this->id)
                ->select('salesnotes.*' )->get();
        } else {
            $sale_note_not_payment = $sale_note_not_payment ->select('salesnotes.*')->get();
        }
        $sale_note_not_payment = SalesNoteNotPayment::collection($sale_note_not_payment);


        // INSTALACION O ENGREAGA DE TRABAJOS CON OBJETO RESOURCE
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
        $sale_note_not_delivered = SalesNoteNotDelivered::collection($sale_note_not_delivered);

        // ENVIO DE RECOMENDACIONES CON OBJETO RESORUCE
        $qualities_send_info = Quality::query()->with(['global' => function($q) {
            $q->with('client', 'user');
        }])->leftJoin('cglobals', 'cglobals.id',   'qualities.cglobal_id')
            ->whereRaw('DATEDIFF(now() , qualities.moment) >= 0')
            ->where('qualities.status_id', 1);
        if ( $this->position !== 1) {
            $qualities_send_info = $qualities_send_info->where('cglobals.user_id', $this->id)
                ->select('qualities.*' )->get();
        } else {
            $qualities_send_info = $qualities_send_info ->select('qualities.*')->get();
        }
        $qualities_send_info = QualitiesSendInfo::collection($qualities_send_info);


        // CONFIRMACION  DE RECOMENDACIONES CON OBJETO RESOURCE
        $qualities_send_info_confirm = Quality::query()->with(['global' => function($q) {
            $q->with('client', 'user');
        }])->leftJoin('cglobals', 'cglobals.id',   'qualities.cglobal_id')
            ->whereRaw('DATEDIFF(now() , qualities.info_send_date) >= 7')
            ->where('qualities.status_id', 2);
        if ( $this->position !== 2) {
            $qualities_send_info_confirm = $qualities_send_info_confirm->where('cglobals.user_id', $this->id)
                ->select('qualities.*' )->get();
        } else {
            $qualities_send_info_confirm = $qualities_send_info_confirm ->select('qualities.*')->get();
        }
        $qualities_send_info_confirm = QualitiesSendInfoConfirm::collection( $qualities_send_info_confirm);

        // COTIZACION  A DOMICIOLIO TERMINADA
        $quote_home_end = Quote::query()->with(['globals' => function($q) {
            $q->with('client', 'user');
        }])->leftJoin('cglobals', 'cglobals.id',   'quotes.cglobal_id')
            ->whereRaw('DATEDIFF(now(), quotes.check_date) >= 0')
            ->where('quotes.status_id', 10)
            ->where('quotes.type_quote_id', 1);
        if ( $this->position !== 1) {
            $quote_home_end =  $quote_home_end->where('cglobals.user_id', $this->id)
                ->select('quotes.*' )->get();
        } else {
            $quote_home_end = $quote_home_end->select('quotes.*')->get();
        }

        $data = [
            'landscapers' => $landscapers,

            'quoteconfirm' => $quote_confirm,

            'quotetracing' => $quote_tracing,

            'sale_note_not_close' => $salen_note_not_close,

            'visit_home_end' => $quote_home_end,

            'quote_local_close' => $quote_local_close,

            'sale_note_not_payment' => $sale_note_not_payment,

            'sale_note_not_delivered' => $sale_note_not_delivered,

            'qualities_send_info' => $qualities_send_info,

            'qualities_send_info_confirm' => $qualities_send_info_confirm
        ];

        return $data;

    }

    public function exitNotify() {

        $data = $this->Notifications();
        $land = count($data['landscapers']) > 0;
        $quoteconfirm = count($data['quoteconfirm']) > 0;
        $quotetracing = count($data['quotetracing']) > 0;
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
