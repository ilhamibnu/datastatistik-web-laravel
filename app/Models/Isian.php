<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Isian extends Model
{
    use HasFactory;

    protected $table = "tb_isian";

    protected $fillable = [
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'rencana_kinerja',
        'kegiatan',
        'progres',
        'capaian',
        'data_dukung',
        'link_foto',
        'id_user'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
