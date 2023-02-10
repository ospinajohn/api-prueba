<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class orderdetailSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::table('orderdetails')->insert([
            [
                'cantidad'   => 1,
                'precio'     => 10000,
                'total'      => 10000,
                'product_id' => 1,
            ],
            [
                'cantidad'   => 2,
                'precio'     => 10000,
                'total'      => 20000,
                'product_id' => 2,
            ],
            [
                'cantidad'   => 3,
                'precio'     => 10000,
                'total'      => 30000,
                'product_id' => 3,
            ],

        ]);
    }
}