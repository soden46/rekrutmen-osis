<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPenerimaan extends Model
{
    use HasFactory;
    public $table = "hasil_akhir";
    protected $primary = 'id_hasil';
    protected $guarded = [];

    public function pendaftaran()
    {
        return $this->hasOne(DataPendaftaran::class, 'id_pendaftaran', 'id_pendaftaran');
    }
}
