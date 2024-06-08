<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJadwaltes extends Model
{
    use HasFactory;
    public $table = "jadwal_tes";
    protected $primary = 'id_jadwal';
    protected $guarded = [];

    public function siswa()
    {
        return $this->hasOne(SiswaModel::class, 'id_siswa', 'id_siswa');
    }
}
