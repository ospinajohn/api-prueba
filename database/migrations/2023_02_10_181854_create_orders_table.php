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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha'); // Fecha de la orden
            $table->integer('total'); // Total de la orden
            $table->string('estado', 100); // Estado de la orden

            // relacion con usuario
            $table->integer('user_id')->unsigned(); // Relación con la tabla users
            $table->foreign('user_id')->references('id')->on('users'); // Llave foránea

            // relacion con detalle de orden
            $table->integer('orderdetail_id')->unsigned(); // Relación con la tabla orderdetails
            $table->foreign('orderdetail_id')->references('id')->on('orderdetails'); // Llave foránea


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('orders');
    }
};