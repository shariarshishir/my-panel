<?php

namespace App\Models\Manufacture;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProformaProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql2';
    protected $table='proforma_product';

    protected $fillable=['performa_id ', 'supplier_id', 'product_id', 'unit', 'unit_price', 'tax', 'total_price', 'tax_total_price', 'created_at', 'updated_at','price_unit'];

    public function supplier(){
        return $this->belongsTo('App\Models\User','supplier_id');
    }

    public function product(){
        return $this->belongsTo('App\Models\Manufacture\Product','product_id');
    }

}
