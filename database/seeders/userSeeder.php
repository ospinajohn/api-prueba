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
                'password' => \Hash::make('12345678'),
                'telefono' => 123456789,
                'rol'      => 'admin',
            ],
            [
                'nombre'   => 'John James',
                'correo'   => 'ospina@gmail.com',
                'password' => \Hash::make('12345678'),
                'telefono' => 123456789,
                'rol'      => 'cliente',
            ],
            [
                'name'     => 'Leiner Felipe',
                'email'    => 'leiner@gmail.com',
                'password' => \Hash::make('12345678'),
                'telefono' => 123456789,
                'rol'      => 'cliente',
            ]
        ]);
    }
}