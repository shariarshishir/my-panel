<?php

namespace App\Models\Manufacture;

use App\Models\BusinessProfile;
use App\Models\ManufactureProductVideo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $connection = 'mysql2';
    protected $guarded=[];
    protected $casts=[
        'product_image'=>'array',
        'colors'=>'array',
        'sizes'=>'array',
        'product_type_mapping_child_id' => 'array',
        'product_tag' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\\Manufacture\ProductCategory','product_category');
    }

    public function product_images(){
        return $this->hasMany('App\Models\\Manufacture\ProductImage','product_id');
    }

    public function businessProfile()
    {
        return $this->belongsTo(BusinessProfile::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function product_video(){
        return $this->hasOne('App\Models\\Manufacture\ProductVideo','product_id','id');
    }

}
