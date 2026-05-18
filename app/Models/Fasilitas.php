<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';

    protected $fillable = [
        'id_paket',
        'tipe_fasilitas',
        'nama_fasilitas',
        'image'
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'id_fasilitas');
    }
}
