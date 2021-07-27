<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelurahan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelurahan', 64);
            $table->string('nama_kecamatan', 64);
            $table->string('nama_kabupaten', 64);
            $table->string('alamat', 191);
            $table->string('nama_lurah', 64);
            $table->string('alamat_lurah', 64);
            $table->string('logo', 64);
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
        Schema::dropIfExists('kelurahan');
    }
}
