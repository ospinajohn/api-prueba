<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class orderSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::table('orders')->insert([
            [
                'fecha'          => '2021-05-01',
                'total'          => 10000,
                'user_id'        => 2,
                'orderdetail_id' => 1,
                'estado'         => 'pendiente',
            ],
            [
                'fecha'          => '2021-05-01',
                'total'          => 20000,
                'user_id'        => 2,
                'orderdetail_id' => 2,
                'estado'         => 'pendiente',
            ],
            [
                'fecha'          => '2021-05-01',
                'total'          => 30000,
                'user_id'        => 2,
                'orderdetail_id' => 3,
                'estado'         => 'pendiente',
            ],
        ]);
    }
}