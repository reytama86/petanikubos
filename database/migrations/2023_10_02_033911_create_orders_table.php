<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_total', function (Blueprint $table) {
            $table->id('id_tt');
            $table->integer('id_user');
            $table->integer('total_harga');
            $table->string('status');
            $table->timestamps();
        });
        Schema::create('transaksi_detail', function (Blueprint $table) {
            $table->id('id_td');
            $table->integer('id_tt');
            $table->integer('id_produk');
            $table->string('nama_produk');
            $table->integer('harga');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
