<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembinaModel extends Model
{
    use HasFactory;
    public $table = "pembina";
    protected $primary = 'id_pembina';
    protected $guarded = [];

    public function users()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
