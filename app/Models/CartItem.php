<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';
    protected $guarded=[];
    public function businessProfile()
    {
        return $this->belongsTo(BusinessProfile::class,'business_profile_id');
    }
}
