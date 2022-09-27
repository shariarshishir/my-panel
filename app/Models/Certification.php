<?php

namespace App\Models;

use App\Models\Admin\Certification as AdminCertification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function businessProfile()
    {
        return $this->belongsTo(BusinessProfile::class);
    }

    public function default_certification()
    {
        return $this->belongsTo(AdminCertification::class, 'admin_certification_id');
    }

}
