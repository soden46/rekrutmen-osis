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
        Schema::create('hasil_akhir', function (Blueprint $table) {
            $table->id('id_hasil');
            $table->foreignId('id_pendaftaran')->constrained('pendaftaran', 'id_pendaftaran');
            $table->enum('nama_tes', ['tes tertulis', 'tes wawncara', 'tes latihan']);
            $table->integer('skor_final');
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
        Schema::dropIfExists('hasil_akhir');
    }
};
