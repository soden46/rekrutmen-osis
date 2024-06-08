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

    public function ekskul()
    {
        return $this->hasOne(EkskulModel::class, 'id_ekskul', 'id_ekskul');
    }

    public function siswa()
    {
        return $this->hasOne(SiswaModel::class, 'id_siswa', 'id_siswa');
    }
}
