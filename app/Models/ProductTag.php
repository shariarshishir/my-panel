<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    /**
     * The business mapping that belong to the tag.
     */
    public function tagMapping()
    {
        return $this->belongsToMany(BusinessMappingTree::class, 'tag_mapping', 'product_tag_id', 'business_mapping_id');
    }
}
