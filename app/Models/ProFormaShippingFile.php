<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProFormaShippingFile extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $guarded=[];
    public function proforma()
    {
        return $this->belongsTo(Proforma::class);
    }
}
