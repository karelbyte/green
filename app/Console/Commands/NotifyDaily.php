<?php

namespace App\Console\Commands;

use App\Entities\NotificationDaily;
use App\Http\Controllers\NotificationsController;
use App\Mail\MailAlertDaily;
use App\Models\Company;
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
        $users = User::query()->where('position_id', 1)->get();

        foreach ($users as $user) {

            $daily = new NotificationDaily($user->id, 1);

            if ($daily->exitNotify()) {
                $data_email = [
                    'user' => $user,
                    'data' => $daily->Daily(),
                    'company' => Company::query()->find(1),
                ];

                Mail::to($user->email)->send(new MailAlertDaily($data_email));
            }
        }
    }
}
