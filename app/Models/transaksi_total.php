<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi_total extends Model
{
    use HasFactory;
    protected $guarded =[];

    protected $table = 'transaksi_total';
    protected $primaryKey = 'id_tt';
    protected $fillable = [
        'status',
    ];
    //protected $table = 'order_details';

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_user','id_user');
    }

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
    
}
