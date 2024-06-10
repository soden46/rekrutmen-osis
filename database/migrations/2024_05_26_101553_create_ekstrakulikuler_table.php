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
        Schema::create('ekstrakulikuler', function (Blueprint $table) {
            $table->id('id_ekskul'); // kolom auto-increment utama
            $table->bigInteger('id_pembina')->constrained('pembina', 'id_pembina')->restrictOnDelete();
            $table->string('nama_ekskul', 100);
            $table->string('nama_pembina', 100);
            $table->bigInteger('jml_anggota'); // mengubah menjadi bigInteger
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
        Schema::dropIfExists('ekstrakulikuler');
    }
};
