<?php

namespace App\Models\Manufacture;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $guarded=[];

    public function subcategories(){

        return $this->hasMany('App\Models\Manufacture\ProductSubcategory','product_category_id');

    }
    
}
