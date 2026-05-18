<?php

namespace App\Models;

use App\Models\Fasilitas;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['path', 'keterangan', 'type', 'id_fasilitas', 'id_destinasi'];

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class);
    }

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class, 'id_destinasi');
    }

    /**
     * Get the paket through destinasi relationship.
     */
    public function paket()
    {
        return $this->hasOneThrough(
            \App\Models\Paket::class,
            \App\Models\Destinasi::class,
            'id',           // destinasis.id
            'id',           // pakets.id
            'id_destinasi', // galleries.id_destinasi
            'id_paket'      // destinasis.id_paket
        );
    }

    /**
     * Check if the gallery item is a video.
     */
    public function isVideo(): bool
    {
        return $this->type === 'video';
    }
}
