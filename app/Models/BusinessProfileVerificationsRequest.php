<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessProfileVerificationsRequest extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'business_profile_verifications_request';
    public function businessProfile()
    {
        return $this->belongsTo(BusinessProfile::class);
    }

}
