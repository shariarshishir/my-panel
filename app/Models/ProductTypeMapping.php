<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTypeMapping extends Model
{
    use HasFactory;


    public function studio()
    {
        return $this->hasMany(ProductTypeMapping::class, 'parent_id', 'id')->where('parent_id', 1);
    }
    public function rawMaterials()
    {
        return $this->hasMany(ProductTypeMapping::class, 'parent_id', 'id')->where('parent_id', 2);
    }

    public function parent()
    {
        return $this->belongsTo(ProductTypeMapping::class,'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductTypeMapping::class,'parent_id');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }
}
