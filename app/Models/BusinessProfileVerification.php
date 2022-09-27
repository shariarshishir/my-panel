<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessProfileVerification extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function businessProfile()
    {
        return $this->belongsTo(BusinessProfile::class);
    }

}
