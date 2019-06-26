<?php

namespace App\Console\Commands;

use App\Mail\AlertCalendarDaily;
use App\Models\Calendar;
use App\Models\Company;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CalendarDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notificación diaria de calendario';

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

        $users = \App\Models\Users\User::all();
        foreach ($users as $user) {
            $data = \App\Models\Calendar::query()->where('user_id', $user->id)
                ->whereDate('start', \Carbon\Carbon::now())->get();
            if (count($data) > 0) {
                $data_email = [
                    'user' => $user,
                    'events' =>  $data,
                    'company' => \App\Models\Company::query()->find(1),
                ];
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AlertCalendarDaily($data_email));
            }
        }
        foreach ($users as $user) {
            $data = \App\Models\Calendar::query()->where('for_user_id', $user->id)
                ->whereDate('start', \Carbon\Carbon::now())->get();
            if (count($data) > 0) {
                $data_email = [
                    'user' => $user,
                    'events' =>  $data,
                    'company' => \App\Models\Company::query()->find(1),
                ];
                \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\AlertCalendarDaily($data_email));
            }
        }
    }
}
