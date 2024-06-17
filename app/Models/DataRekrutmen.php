<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRekrutmen extends Model
{
    use HasFactory;

    public $table = "rekrutmen";
    protected $primaryKey = 'id_rekrutmen';
    protected $guarded = [];

    public function ekskul()
    {
        return $this->hasOne(EkskulModel::class, 'id_ekskul', 'id_ekskul');
    }

    public function jadwalTes()
    {
        return $this->hasMany(DataJadwaltes::class, 'id_rekrutmen');
    }

    public function pendaftaran()
    {
        return $this->hasMany(DataPendaftaran::class, 'id_rekrutmen');
    }
}
