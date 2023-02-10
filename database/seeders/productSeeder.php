<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class productSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //base de datos
        \DB::table('products')->insert([
            [
                'nombre' => 'Arroz',
                'precio' => 3520,
                'stock'  => 100,
            ],
            [
                'nombre' => 'Lentejas',
                'precio' => 2500,
                'stock'  => 19,
            ],
            [
                'nombre' => 'Atun',
                'precio' => 3500,
                'stock'  => 10,
            ],
            [
                'nombre' => 'Papa',
                'precio' => 3500,
                'stock'  => 10,
            ],
        ]);
    }
}