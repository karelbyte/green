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

        $statusList = [
            ['id' => 0, 'name' => 'Inactivo'],
            ['id' => 1, 'name' => 'Activo'],
        ];

        \App\Models\UserStatus::insert($statusList);

        /*
        \App\Models\User::create([
            'name' => 'Administrador',
            'email' => 'admin@gc.com',
            'password' => \Illuminate\Support\Facades\Hash::make('gc12345*-'),
            'active_id' => 1
        ]);*/
    }
}
