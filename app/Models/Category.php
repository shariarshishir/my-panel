<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
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

    public static function boot()
    {

        parent::boot();
    }


}
