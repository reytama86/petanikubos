<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'keranjang';

    public function member()
    {
        return $this->belongsTo(Member::class,'id_member','id_keranjang');
    }

    public function product()
    {
        return $this->belongsTo(Produk::class,'id_produk','id_keranjang');
    }
}
