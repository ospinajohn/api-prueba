<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('orderdetails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cantidad');
            $table->integer('precio');
            $table->integer('total');

            $table->integer('product_id')->unsigned(); // Relación con la tabla products
            $table->foreign('product_id')->references('id')->on('products'); // Llave foránea

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('orderdetails');
    }
};