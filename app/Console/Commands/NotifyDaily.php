<?php

namespace App\Console\Commands;

use App\Entities\NotificationDaily;
use App\Http\Controllers\NotificationsController;
use App\Http\Resources\VisitHomeNotification;
use App\Mail\MailAlertDaily;
use App\Models\Company;
use App\Models\LandScaper;
use App\Models\Qualities\Quality;
use App\Models\Quotes\Quote;
use App\Models\SalesNotes\SalesNote;
use App\Models\Users\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NotifyDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notificacion diraria';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::query()->where('position_id', 1)
            ->where('active_id', 1)
            ->get();

        foreach ($users as $user) {

            $landscapers = LandScaper::query()->with(['user', 'global' => function($q) {
                $q->with('client', 'quote');
            }])->leftJoin('cglobals', 'cglobals.id',   'landscapers.cglobal_id')
                ->whereRaw('DATEDIFF(now(), landscapers.moment) >= 0')
                ->where('landscapers.status_id',  0);
            if ( (int) $user->position_id !== 1) {
                $landscapers =  $landscapers->where('cglobals.user_id', $user->id)
                    ->select('landscapers.*')->get();
            } else {
                $landscapers =  $landscapers->select('landscapers.*')->get();
            }

            $quote_confirm = Quote::with(['globals' => function($q) {
                $q->with('client', 'user');
            }])->leftJoin('cglobals', 'cglobals.id',   'quotes.cglobal_id')
                ->whereRaw('DATEDIFF(now(), quotes.check_date ) > 1')
                ->where('quotes.status_id', 3);
            if ((int) $user->position_id !== 1) {
                $quote_confirm = $quote_confirm->where('cglobals.user_id', $user->id)
                    ->select('quotes.*')->get();
            } else {
                $quote_confirm = $quote_confirm->select('quotes.*')->get();
            }


            $quote_tracing = Quote::with(['globals' => function($q) {
                $q->with('client', 'user');
            }])->leftJoin('cglobals', 'cglobals.id',   'quotes.cglobal_id')
                ->whereRaw('DATEDIFF(now(), quotes.check_date ) >= 0')
                ->where('quotes.status_id', 7); // SEGUIMIENTO
            if ( (int) $user->position_id !== 1) {
                $quote_tracing = $quote_tracing->where('cglobals.user_id', $user->id)
                    ->select('quotes.*')->get();
            } else {
                $quote_tracing = $quote_tracing->select('quotes.*')->get();
            }


            // COTIZACION A DISTANCIA  CREADA SIN CONTENIDO CON OBJETO RESOURCE
            $quote_local_close = Quote::query()->with(['globals' => function($q) {
                $q->with('client', 'user');
            }])->leftJoin('cglobals', 'cglobals.id',   'quotes.cglobal_id')
                ->whereRaw('DATEDIFF(now(), quotes.moment) >= 0')
                ->where('quotes.status_id', 2)
                ->where('quotes.type_quote_id', 2);
            if ((int) $user->position_id !== 1) {
                $quote_local_close =  $quote_local_close->where('cglobals.user_id', $user->id)
                    ->select('quotes.*' )->get();
            } else {
                $quote_local_close = $quote_local_close->select('quotes.*')->get();
            }

            $sale_note_not_payment = SalesNote::query()->with(['globals' => function($q) {
                $q->with('client', 'user');
            }])->leftJoin('cglobals', 'cglobals.id',   'salesnotes.global_id')
                ->whereRaw('DATEDIFF(now() , salesnotes.paimentdate) >= 0')
                ->wherein('salesnotes.status_id', [1, 4, 6, 8]);
            if ( (int) $user->position_id !== 1) {
                $sale_note_not_payment = $sale_note_not_payment ->where('cglobals.user_id', $user->id)
                    ->select('salesnotes.*' )->get();
            } else {
                $sale_note_not_payment = $sale_note_not_payment ->select('salesnotes.*')->get();
            }

            // INSTALACION O ENGREAGA DE TRABAJOS CON OBJETO RESOURCE
            $sale_note_not_delivered = SalesNote::query()->with(['globals' => function($q) {
                $q->with('client', 'user', 'MotiveServices', 'MotiveProducts');
            }])->leftJoin('cglobals', 'cglobals.id',   'salesnotes.global_id')
                ->whereRaw('DATEDIFF(now() , salesnotes.deliverydate) >= 0')
                ->wherein('salesnotes.status_id', [ 4, 5, 6]);
            if ( (int) $user->position_id !== 1) {
                $sale_note_not_delivered = $sale_note_not_delivered->where('cglobals.user_id', $user->id)
                    ->select('salesnotes.*' )->get();
            } else {
                $sale_note_not_delivered = $sale_note_not_delivered ->select('salesnotes.*')->get();
            }


            $qualities_send_info = Quality::query()->with(['global' => function($q) {
                $q->with('client', 'user');
            }])->leftJoin('cglobals', 'cglobals.id',   'qualities.cglobal_id')
                ->whereRaw('DATEDIFF(now() , qualities.moment) >= 0')
                ->where('qualities.status_id', 1);
            if ( (int) $user->position_id !== 1) {
                $qualities_send_info = $qualities_send_info->where('cglobals.user_id', $user->id)
                    ->select('qualities.*' )->get();
            } else {
                $qualities_send_info = $qualities_send_info ->select('qualities.*')->get();
            }


            // CONFIRMACION  DE RECOMENDACIONES CON OBJETO RESOURCE
            $qualities_send_info_confirm = Quality::query()->with(['global' => function($q) {
                $q->with('client', 'user');
            }])->leftJoin('cglobals', 'cglobals.id',   'qualities.cglobal_id')
                ->whereRaw('DATEDIFF(now() , qualities.info_send_date) >= 7')
                ->where('qualities.status_id', 2);
            if (  (int) $user->position_id !== 1) {
                $qualities_send_info_confirm = $qualities_send_info_confirm->where('cglobals.user_id', $user->id)
                    ->select('qualities.*' )->get();
            } else {
                $qualities_send_info_confirm = $qualities_send_info_confirm ->select('qualities.*')->get();
            }

            $data = [
                'landscapers' => $landscapers,

                'quoteconfirm' => $quote_confirm,

                'quotetracing' =>  $quote_tracing,

                'sale_note_not_close' => [],

                'visit_home_end' => [],

                'quote_local_close' => $quote_local_close,

                'sale_note_not_payment' => $sale_note_not_payment,

                'sale_note_not_delivered' => $sale_note_not_delivered,

                'qualities_send_info' => $qualities_send_info,

                'qualities_send_info_confirm' => $qualities_send_info_confirm
            ];

                $data_email = [
                    'user' => $user,
                    'data' => $data,
                    'company' => Company::query()->find(1),
                ];

                Mail::to($user->email)->send(new MailAlertDaily($data_email));
            }
    }

}
