<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaModel extends Model
{
    use HasFactory;
    public $table = "siswa";
    protected $primary = 'id_siswa';
    protected $guarded = [];

    public function users()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
