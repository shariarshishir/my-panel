<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModification extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $guarded=['id'];

    public function orderItem()
    {
        return $this->hasOne(VendorOrderItem::class, 'order_modification_id','id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class,'product_sku','sku')->withTrashed();
    }

    public function orderModificationRequest()
    {
        return $this->belongsTo(OrderModificationRequest::class, 'order_modification_request_id');
    }
}
