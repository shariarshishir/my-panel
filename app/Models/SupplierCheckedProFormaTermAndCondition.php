<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierCheckedProFormaTermAndCondition extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function proforma()
    {
        return $this->belongsTo(Proforma::class);
    }
    public function proFormaTermAndCondition()
    {
        return $this->belongsTo(ProFormaTermAndCondition::class);
    }
}
