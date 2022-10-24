<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';
    protected $casts = [
        'product_type_mapping_child_id' => 'array',
        'product_tag' => 'array',
    ];

    protected $guarded=[];

    // public function vendor()
    // {
    //     return $this->belongsTo(Vendor::class);
    // }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function category()
    {
        return $this->belongsTo(ProductCategory::class,'product_category_id');
    }

    public function productWishLists()
    {
        return $this->hasMany(ProductWishlist::class);
    }

    public function productReview()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function businessProfile()
    {
        return $this->belongsTo(BusinessProfile::class);
    }

    public function video()
    {
        return $this->hasOne(ProductVideo::class);
    }


    // protected static $relations_to_cascade = ['images','productWishLists'];

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function($resource) {
    //         foreach (static::$relations_to_cascade as $relation) {
    //             foreach ($resource->{$relation}()->get() as $item) {
    //                 $item->delete();
    //             }
    //         }
    //     });

    //     static::restoring(function($resource) {
    //         foreach (static::$relations_to_cascade as $relation) {
    //             foreach ($resource->{$relation}()->get() as $item) {
    //                 $item->withTrashed()->restore();
    //             }
    //         }
    //     });
    // }




}
