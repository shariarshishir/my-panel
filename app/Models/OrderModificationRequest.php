<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class OrderModificationRequest extends Model
{
    use HasFactory ,Notifiable;

    protected $connection = 'mysql';
    protected $guarded=[];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function comments()
    {
        return $this->hasMany(OrderModificationComment::class)->whereNull('parent_id');
    }

    public function orderModification()
    {
        return $this->hasOne(OrderModification::class);
    }

    public function businessProfile()
    {
        return $this->belongsTo(BusinessProfile::class);
    }
}
