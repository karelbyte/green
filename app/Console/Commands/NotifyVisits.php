<?php

namespace App\Console\Commands;

use App\Mail\AlertLandscape;
use App\Models\Company;
use App\Models\LandScaper;
use App\Models\Users\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NotifyVisits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:visits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notificar visitas';

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
        $landscapers = LandScaper::query()->with(['user', 'global' => function($q) {
            $q->with('client');
        }])->leftJoin('cglobals', 'cglobals.id',   'landscapers.cglobal_id')
            ->whereRaw('DATEDIFF( now(), landscapers.moment) >= 0')
            ->where('landscapers.status_id', 0)->get();


       foreach ($landscapers as $scaper) {

           $generador = User::query()->where('id',  $scaper->global->user_id)->first();

           $data_email = [
               'user' => $scaper->user,
               'generador' =>  $generador->name,
               'visit' => $scaper,
               'client' =>  $scaper->global->client,
               'company' => Company::query()->find(1),
           ];
           Mail::to( $scaper->user->email)->send(new AlertLandscape($data_email));
       }
    }
}
