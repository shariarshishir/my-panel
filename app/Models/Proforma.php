<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    use HasFactory;

    protected $fillable=['buyer_id', 'proforma_id', 'proforma_date', 'payment_within', 'po_no', 'condition', 'updated_buyer_name', 'updated_buyer_email', 'updated_buyer_shipping_address', 'status', 'created_at', 'updated_at'];

    public function buyer(){
        return $this->belongsTo('App\Models\User','buyer_id');
    }

    public function performa_items(){
        return $this->hasMany('App\Models\ProformaProduct','performa_id');
    }
    public function checkedMerchantAssistances(){
        return $this->hasMany('App\Models\ProformaCheckedMerchantAssistance');
    }
    public function proFormaShippingDetails(){
        return $this->hasMany('App\Models\ProFormaShippingDetails');
    }
    public function proFormaAdvisingBank(){
        return $this->hasOne('App\Models\ProFormaAdvisingBank');
    }
    public function proFormaShippingFiles(){
        return $this->hasMany('App\Models\ProFormaShippingFile');
    }
    public function supplierCheckedProFormaTermAndConditions(){
        return $this->hasMany('App\Models\SupplierCheckedProFormaTermAndCondition');
    }
    public function proFormaSignature(){
        return $this->hasOne('App\Models\ProFormaSignature');
    }
    public function businessProfile(){
        return $this->belongsTo('App\Models\BusinessProfile');
    }
    public function paymentTerm(){
        return $this->belongsTo('App\Models\PaymentTerm');
    }
    public function shipmentTerm(){
        return $this->belongsTo('App\Models\ShipmentTerm');
    }

}
