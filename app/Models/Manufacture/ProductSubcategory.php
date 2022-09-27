<?php

namespace App\Models\Manufacture;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSubcategory extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $guarded=[];

    public function category(){

        return $this->belongsTo('App\Models\Manufacture\ProductCategory','product_category_id');

    }
}
