<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPendaftaran extends Model
{
    use HasFactory;
    public $table = "pendaftaran";
    protected $primary = 'id_pendaftaran';
    protected $guarded = [];

    public function rekrutmen()
    {
        return $this->hasOne(DataRekrutmen::class, 'id_rekrutmen', 'id_rekrutmen');
    }

    public function siswa()
    {
        return $this->hasOne(SiswaModel::class, 'id_siswa', 'id_siswa');
    }

    public function dokumen()
    {
        return $this->hasMany(DokumenPendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}
