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
        Schema::create('anggota_ekstrakulikuler', function (Blueprint $table) {
            $table->id('id_anggota');
            $table->foreignId('id_siswa')->constrained('siswa', 'id_siswa')->restrictOnDelete();
            $table->foreignId('id_ekskul')->constrained('ekstrakulikuler', 'id_ekskul')->restrictOnDelete();
            $table->string('tugas', 20);
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
        Schema::dropIfExists('anggota_ekstrakulikuler');
    }
};
