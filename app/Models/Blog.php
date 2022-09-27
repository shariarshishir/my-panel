<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable=['title','slug','source','author_name','author_note', 'author_img','photo_credit', 'details', 'feature_image','meta_title','meta_description','meta_image','meta_type', 'created_by'];
	protected $casts=['source'=>'array'];

    public function created_user(){

        return $this->belongsTo('App\Models\Admin','created_by');

    }
    public function metaInformation(){

        return $this->hasOne('App\Models\MetaInformation','blog_id');

    }
}
