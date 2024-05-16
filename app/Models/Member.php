<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'user';
    protected $fillable = [
        'nama', // Pastikan atribut ini ada
        'email',
        // ...
    ];
    
    public function order()
    {
        return $this->hasMany(transaksi_total::class);
    }
    public function cart()
    {
        return $this->hasMany(Keranjang::class);
    }
}
