<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Userchat extends Model
{
	protected $connection = 'mongodb';
    protected $collection = 'message';
    // protected $fillable = ['participates','chatdata'];
}
