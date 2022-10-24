<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rfq extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded=[];

    public function images(){
        return $this->hasMany('App\Models\RfqImage','rfq_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function bids()
    {
        return $this->hasMany('App\Models\SupplierBid', 'rfq_id')->withTrashed();
    }

    public function category(){
        return $this->belongsTo('App\Models\Manufacture\ProductCategory','category_id');
    }

    public function businessProfile()
    {
        return $this->belongsTo('App\Models\BusinessProfile', 'created_by')->withTrashed();
    }

    public function supplierQuotationToBuyer()
    {
        return $this->belongsTo('App\Models\BusinessProfile', 'rfq_id')->withTrashed();
    }

}
