<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriesProduced extends Model
{
    use HasFactory;
    public function businessProfile()
    {
        return $this->belongsTo(BusinessProfile::class);
    }
}
