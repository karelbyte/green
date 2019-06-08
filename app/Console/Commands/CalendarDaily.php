<?php

namespace App\Console\Commands;

use App\Mail\AlertCalendarDaily;
use App\Models\Calendar;
use App\Models\Company;
use App\Models\Users\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
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
        $users = User::all();
        foreach ($users as $user) {
            $data =  Calendar::query()->where('user_id', $user->id)->whereDate('start', Carbon::now())->get();
            if (count($data) > 0) {
                $data_email = [
                    'user' => $user,
                    'events' =>  $data,
                    'company' => Company::query()->find(1),
                ];
                Mail::to( $user->email)->send(new AlertCalendarDaily($data_email));
            }
        }
    }
}
