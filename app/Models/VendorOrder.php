<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorOrder extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $guarded=['id'];

    public function orderItems()
    {
        return $this->hasMany(VendorOrderItem::class,'order_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(UserAddress::class,'billing_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(UserAddress::class,'shipping_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function shippingCharge(){
        return $this->hasOne(ShippingCharge::class,'order_id');
    }
    public function businessProfile()
    {
        return $this->belongsTo(BusinessProfile::class,'business_profile_id');
    }


}
