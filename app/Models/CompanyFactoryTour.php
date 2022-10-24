<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyFactoryTour extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function businessProfile()
    {
        return $this->belongsTo(BusinessProfile::class);
    }
    public function companyFactoryTourImages(){
        return $this->hasMany(CompanyFactoryTourImage::class);
    }
    public function companyFactoryTourLargeImages(){
        return $this->hasMany(CompanyFactoryTourLargeImage::class);
    }
}
