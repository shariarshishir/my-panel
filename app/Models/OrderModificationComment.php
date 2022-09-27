<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderModificationComment extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $guarded=[];
    /**
     * The has Many Relationship
     *
     * @var array
     */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }

    public function replies()
    {
        return $this->hasMany(OrderModificationComment::class, 'parent_id');
    }

    public function orderModificationRequest()
    {
        return $this->belongsTo(OrderModificationRequest::class, 'order_modification_request_id');
    }


}
