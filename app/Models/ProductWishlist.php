<?php

namespace App\Models;

use App\Models\Manufacture\Product as manufactureProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProductWishlist extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function manufacture_product()
    {
        return $this->belongsTo(manufactureProduct::class, 'manufacture_product_id');
    }
}
