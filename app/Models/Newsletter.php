<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;
    protected $fillable=['title', 'pdf_path', 'description', 'created_by'];
	protected $casts=['source'=>'array'];

    public function created_user(){
        return $this->belongsTo('App\Models\Admin','created_by');
    }
}
