<?php

namespace App\Models\Manufacture;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVideo extends Model
{
    protected $connection = 'mysql2';
    protected $table='product_videos';
    protected $guarded=[];
    use HasFactory;
}
