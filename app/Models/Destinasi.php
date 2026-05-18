<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Destinasi extends Model
{
    protected $fillable = [
        'id_paket',
        'nama_destinasi',
        'image'
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket');
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'id_destinasi');
    }
}
