<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Designers extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'designers_info';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function portfolioImages()
    {
        return $this->hasMany(DesignerPortfolio::class);
    }
}
