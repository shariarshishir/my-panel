<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessMappingTree extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function parent()
    {
        return $this->belongsTo(BusinessMappingTree::class,'parent_id');
    }

    public function children()
    {
        return $this->hasMany(BusinessMappingTree::class,'parent_id');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

     /**
     * The business mapping that belong to the tag.
     */
    public function tagMapping()
    {
        return $this->belongsToMany(ProductTag::class, 'tag_mapping','business_mapping_id', 'product_tag_id');
    }
}
