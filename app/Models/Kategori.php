<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori'; // pastikan ini sesuai dengan primary key di tabel

    protected $fillable = [
        'nama_kategori',
    ];

    public function Subcategory()
    {
        return $this->hasMany(Subcategory::class);
    }

    public function product()
    {
        return $this->hasMany(Produk::class);
    }
}
