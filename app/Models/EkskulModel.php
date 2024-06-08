<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EkskulModel extends Model
{
    use HasFactory;
    public $table = "ekstrakulikuler";
    protected $primary = 'id_ekskul';
    protected $guarded = [];

    public function pembina()
    {
        return $this->hasOne(PembinaModel::class, 'id_pembina', 'id_pembina');
    }
}
