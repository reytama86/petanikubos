<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $fillable = [
        'nama_produk',
        'harga',
        'diskripsi',
        'total_jual',
        'id_kategori',
    ];

    public function category()
    {
    return $this->belongsTo(Kategori::class, 'id_kategori');
    }
    public function cart()
    {
        return $this->hasMany(Keranjang::class);
    }

}
