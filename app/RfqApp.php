<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class RfqApp extends Model
{
	protected $connection = 'mongodb';
    protected $collection = 'queries';
}
