<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProformaCheckedMerchantAssistance extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $guarded=[];
    
    public function merchantAssistance()
    {
        return $this->belongsTo(MerchantAssistance::class);
    }
}
