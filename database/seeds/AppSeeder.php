<?php

use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /*  $statusUserList = [
            ['id' => 0, 'name' => 'Inactivo'],
            ['id' => 1, 'name' => 'Activo'],
        ];

        \App\Models\UserStatus::insert($statusUserList);


        $statusReceptionList = [
            ['id' => 0, 'name' => 'NO APLICADA'],
            ['id' => 1, 'name' => 'APLICADA'],
        ];

        \App\Models\ReceptionStatus::insert($statusReceptionList);


        \App\Models\User::create([
            'name' => 'Administrador',
            'email' => 'admin@gc.com',
            'password' => \Illuminate\Support\Facades\Hash::make('gc12345*-'),
            'active_id' => 1
        ]);*/

        for ($i=1; $i<=300; $i++) {

            \App\Models\Client::create([

                'code' => rand(),

                'contact' => $i % 2 == 0 ? 1 : 2,

                'name' => str_shuffle('ABIBDODPWJFUSFAYUB.UBWDI'),

                'email' => str_shuffle('ABIBDODPWJFU').'@d.'. str_shuffle('POIJHOUHGY') . '.com'

            ]);
        }


    }
}
