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
        Schema::create('rekrutmen', function (Blueprint $table) {
            $table->id('id_lowongan');
            $table->foreignId('id_ekskul')->constrained('ekstrakulikuler', 'id_ekskul')->restrictOnDelete();
            $table->string('nama_lowongan', 20);
            $table->date('tanggal_dimulai');
            $table->date('tanggal_berakhir');
            $table->text('deskripsi');
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
        Schema::dropIfExists('lowongan');
    }
};
