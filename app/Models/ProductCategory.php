<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


class ProductCategory extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $guarded=[];

    // public function getStatusAttribute($value)
    // {
    //     return [
    //         1 => 'Published',
    //         0 => 'Unpublished',
    //     ][$value];
    // }

    // public function getParentAttribute($value)
    // {
    //     return [
    //         1 => 'Yes',
    //         0 => 'No',
    //     ][$value];
    // }
    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id', 'id');
    }
    public function products()
    {
        return $this->hasMany(Product::class,'product_category_id');
    }
    public function getAllChildren ()
    {
        $sections = new Collection();
        foreach ($this->children as $section) {
            $sections->push($section);
            $sections = $sections->merge($section->getAllChildren());
        }

        return $sections;
    }

}
