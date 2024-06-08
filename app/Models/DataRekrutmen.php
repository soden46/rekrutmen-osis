<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataRekrutmen extends Model
{
    use HasFactory;

    public $table = "rekrutmen";
    protected $primary = 'id_rekrutmen';
    protected $guarded = [];

    public function ekskul()
    {
        return $this->hasOne(EkskulModel::class, 'id_ekskul', 'id_ekskul');
    }
}
