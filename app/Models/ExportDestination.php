<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExportDestination extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function businessProfile()
    {
        return $this->belongsTo(BusinessProfile::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
