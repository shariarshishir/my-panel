<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designers extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'designers_info';

    public function portfolioImages()
    {
        return $this->hasMany(DesignerPortfolio::class);
    }
}
