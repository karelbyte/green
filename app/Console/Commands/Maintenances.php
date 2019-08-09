<?php

namespace App\Console\Commands;

use App\Models\Maintenances\Maintenance;
use Illuminate\Console\Command;

class Maintenances extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance:gen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $Maintenances = \App\Models\Maintenances\Maintenance::query()->with('mlast')->get();

        foreach ($Maintenances as $maintenance) {
            $ultimo = $maintenance->load('mlast')->mlast[0];
            $date = $ultimo['moment'] . ' ' . $ultimo['visiting_time'];
            $newDate = \Carbon\Carbon::parse($date)->addDays($maintenance->timer);
            $diff = $newDate->diffInDays(\Carbon\Carbon::now());
            if ($diff <= 3) {
                $acestor = \App\Models\SalesNotes\SalesNoteDetails::query()->with(['sale' => function ($q) {
                    $q->with('globals');
                }])->find($maintenance->sales_note_details_id);

                $sale = \App\Models\SalesNotes\SalesNote::query()->create([
                    'global_id' => $acestor->sale->global_id,
                    'moment' => \Carbon\Carbon::now()->addDays(2),
                    'emit' => \Carbon\Carbon::now()->addDays(2),
                    'advance' => 0,
                    'origin' => \App\Models\SalesNotes\SalesNote::ORIGIN_SALE_NOTE,
                    'status_id' => 3,
                ]);

                $sale->details()->create([
                    'type_item' => $acestor['type_item'],
                    'item_id' => $acestor['item_id'],
                    'descrip' => $acestor['descrip'],
                    'measure_id' => $acestor['measure_id'],
                    'cant' => $acestor['cant'],
                    'price' => $acestor['price'],
                ]);
                $sub = $maintenance->details()->create([
                    'moment' => $newDate,
                    'sale_id' => $sale->id,
                    'price' => $sale->total(),
                    'accept' => 1,
                    'status_id' => 1]);

                \App\Models\Calendar::query()->create([
                    'cglobal_id' => $acestor->sale->global_id,
                    'user_id' => $acestor->sale->globals->user_id,
                    'for_user_id' => 0,
                    'start' => $newDate,
                    'end' => $newDate->addHours(2),
                    'title' => 'SERVICIO A : ' . $sale->globals->client->name,
                    'contentFull' => $acestor['descrip'] . '   DOMICILIO: ' . $sale->globals->client->street . ' ' . $sale->globals->client->home_number . ' ' . $sale->globals->client->colony,
                    'mant_id' => $sub->id,
                    'class' => 'mant'
                ]);
            }
        }
    }
}
