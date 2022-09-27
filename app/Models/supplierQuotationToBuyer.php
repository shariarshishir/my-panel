<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplierQuotationToBuyer extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = "rfq_quotation_sent_supplier_to_buyer_rel";
}
