<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsFromTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('bahan');
            $table->dropColumn('tags');
            $table->dropColumn('sku');
            $table->dropColumn('ukuran');
            $table->dropColumn('warna');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('bahan');
            $table->string('tags');
            $table->string('sku');
            $table->string('ukuran');
            $table->string('warna');
        });
    }
}
