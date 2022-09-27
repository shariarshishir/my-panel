<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';
    protected $guarded=[];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
    public function orders()
    {
        return $this->hasMany(VendorOrder::class);
    }
    public function vendorReviews()
    {
        return $this->hasMany(VendorReview::class);
    }
    public function relatedProducts()
    {
        return $this->hasMany(RelatedProduct::class);
    }


    protected static $relations_to_cascade = ['user','products','vendorReviews','relatedProducts'];

    protected static function boot()
    {
        parent::boot();


        static::deleting(function($resource) {
            foreach (static::$relations_to_cascade as $relation) {
                foreach ($resource->{$relation}()->get() as $item) {
                    if(isset($item)){
                        $item->delete();
                    }
                    if($relation == 'user'){
                    if($item->userAddress()->exists()){
                        $item->userAddress()->delete();
                    }
                    }
                    if($relation=="products"){
                        if($item->images()->exists()){
                            $item->images()->delete();
                        }
                        if($item->productReview()->exists()){
                            $item->productReview()->delete();
                        }
                        if($item->productWishLists()->exists()){
                            $item->productWishLists()->delete();
                        }
                    }


                }
            }
        });

        static::restoring(function($resource) {
            foreach (static::$relations_to_cascade as $relation) {
                foreach ($resource->{$relation}()->onlyTrashed()->get() as $item) {
                    if(isset($item)){
                        $item->restore();
                    }
                    if($relation == 'user'){
                        if($item->userAddress()->onlyTrashed()->exists()){
                            $item->userAddress()->onlyTrashed()->restore();
                        }
                     }
                    if($relation=="products"){
                        if($item->images()->onlyTrashed()->exists())
                           $item->images()->onlyTrashed()->restore();

                        if($item->productReview()->onlyTrashed()->exists()){
                            $item->productReview()->onlyTrashed()->restore();
                        }
                        if($item->productWishLists()->onlyTrashed()->exists()){
                            $item->productWishLists()->onlyTrashed()->restore();
                        }
                    }

                }
            }
        });
    }

}
