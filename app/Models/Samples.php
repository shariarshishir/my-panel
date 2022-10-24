<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Samples extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'samples';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function portfolioImages()
    // {
    //     return $this->hasMany(DesignerPortfolio::class);
    // }
}
