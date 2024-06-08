<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminModel extends Model
{
    use HasFactory;
    public $table = "admin";
    protected $primary = 'id_admin';
    protected $guarded = [];

    public function users()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
}
