<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPendaftaran extends Model
{
    use HasFactory;
    public $table = "dokumen_pendaftaran";
    protected $guarded = ['id'];

    protected $fillable = ['id_pendaftaran', 'type', 'path'];
}
