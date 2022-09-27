<?php

namespace App\Models\Manufacture;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table='proforma';
    // protected $casts=[
    //     'performa_items'=>'array',
    // ];


    protected $fillable=['buyer_id', 'proforma_id', 'proforma_date', 'payment_within', 'po_no', 'condition', 'status', 'created_at', 'updated_at'];

    public function buyer(){
        return $this->belongsTo('App\Models\User','buyer_id');
    }

    public function performa_items(){
        return $this->hasMany('App\Models\Manufacture\ProformaProduct','performa_id');
    }
}
