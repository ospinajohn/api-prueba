<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class userSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::table('users')->insert([
            [
                'nombre'   => 'Admin',
                'correo'   => 'admin@gmail.com',
                'password' => \Hash::make('123456'),
                'telefono' => 123456,
                'rol'      => 'admin',
            ],
            [
                'nombre'   => 'John James',
                'correo'   => 'ospina@gmail.com',
                'password' => \Hash::make('123456'),
                'telefono' => 123456,
                'rol'      => 'supervisor',
            ],
            [
                'name'     => 'Prueba - Test',
                'email'    => 'prueba@gmail.com',
                'password' => \Hash::make('123456'),
                'telefono' => 123456,
                'rol'      => 'cliente',
            ]
        ]);
    }
}