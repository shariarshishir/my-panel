<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessProfile extends Model
{
    use HasFactory, SoftDeletes;
    protected $connection = 'mysql';
    protected $guarded=[];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function representativeUser()
    {
        return $this->belongsTo(User::class,'representative_user_id', 'id');
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function companyOverview()
    {
        return $this->hasOne(CompanyOverview::class);
    }
    public function machineriesDetails()
    {
        return $this->hasMany(MachineriesDetail::class);
    }
    public function categoriesProduceds()
    {
        return $this->hasMany(CategoriesProduced::class);
    }
    public function productionCapacities()
    {
        return $this->hasMany(ProductionCapacity::class);
    }
    public function productionFlowAndManpowers()
    {
        return $this->hasMany(ProductionFlowAndManpower::class);
    }
    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }
    public function mainBuyers()
    {
        return $this->hasMany(MainBuyer::class);
    }
    public function exportDestinations()
    {
        return $this->hasMany(ExportDestination::class);
    }
    public function associationMemberships()
    {
        return $this->hasMany(AssociationMembership::class);
    }
    public function pressHighlights()
    {
        return $this->hasMany(PressHighlight::class);
    }

    public function companyFactoryTour()
    {
        return $this->hasMany(CompanyFactoryTour::class);
    }

    public function businessTerms()
    {
        return $this->hasMany(BusinessTerm::class);
    }
    public function samplings()
    {
        return $this->hasMany(Sampling::class);
    }
    public function specialCustomizations()
    {
        return $this->hasMany(SpecialCustomization::class);
    }
    public function sustainabilityCommitments()
    {
        return $this->hasMany(SustainabilityCommitment::class);
    }
    public function walfare()
    {
        return $this->hasOne(Walfare::class);
    }
    public function businessProfileVerificationsRequest(){
        return $this->hasOne(BusinessProfileVerificationsRequest::class);
    }
    public function security()
    {
        return $this->hasOne(Security::class);
    }


    public function businessCategory(){
        return $this->belongsTo('App\Models\Manufacture\ProductCategory','business_category_id');
    }
    public function wholesalerProducts(){
        return $this->hasMany(Product::class)->where(['state' => true, 'sold' => 0 ]);
    }
    public function manufactureProducts(){
        return $this->hasMany('App\Models\\Manufacture\Product','business_profile_id');
    }

    public function wholesalerOrders()
    {
        return $this->hasMany(VendorOrder::class);
    }

    public function relatedProducts(){
        return $this->hasMany(RelatedProduct::class);
    }

    public function profileBasedOrders()
    {
        return $this->hasMany(VendorOrder::class)->whereNotIn('state', ['pending','cancel']);
    }

    public function profileBasedPo()
    {
        return $this->hasMany(Proforma::class);
    }

    public function profileBasedQueries()
    {
        return $this->hasMany(OrderModificationRequest::class)->where('type', 1);
    }

    public function supplierQuotationToBuyer()
    {
        return $this->hasMany(supplierQuotationToBuyer::class);
    }

    public function businessProfileVerification()
    {
        return $this->hasOne(BusinessProfileVerification::class);
    }

}
