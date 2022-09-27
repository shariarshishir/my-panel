<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProFormaShippingDetails extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $guarded=[];
    public function proforma()
    {
        return $this->belongsTo(Proforma::class);
    }
    public function uom(){
        return $this->belongsTo('App\Models\UOM','shipping_details_uom');
    }
    public function shippingMethod(){
        return $this->belongsTo('App\Models\ShippingMethod','shipping_details_method');
    }
    public function shipmentType(){
        return $this->belongsTo('App\Models\ShipmentType','shipping_details_type');
    }
    

}
