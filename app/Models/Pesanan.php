<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanans';

    protected $fillable = [
        'id_paket',
        'nama_pemesan',
        'no_hp',
        'diskon',
        'jumlah_orang',
        'total_harga',
        'tanggal_acara',
        'invoice',
        'status',
        'is_custom',
        'custom_places',
        'custom_fasilitas',
    ];

    protected $casts = [
        'custom_places' => 'array',
        'custom_fasilitas' => 'array',
    ];

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'id_paket');
    }

    public function isCustom()
    {
        return $this->is_custom;
    }

    public function getPlacesAttribute()
    {
        if ($this->is_custom) {
            return $this->custom_places ?? [];
        }
        return $this->paket?->destinasis->pluck('nama_destinasi') ?? [];
    }
}
