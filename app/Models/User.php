<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $connection = 'mysql';

    protected $guarded=[];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];




    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }
    public function countryName()
    {
        return $this->belongsTo(Country::class,'country','code');
    }

    public function vendorOrder()
    {
        return $this->hasMany(VendorOrder::class);
    }
    public function inactiveVendor()
    {
        return $this->hasOne(Vendor::class)->onlyTrashed();
    }

    public function userAddress()
    {
        return $this->hasMany(UserAddress::class);
    }
    public function productWishlist()
    {
        return $this->hasMany(ProductWishlist::class);
    }

    public function businessProfile()
    {
        return $this->hasMany(BusinessProfile::class);
    }

    public function businessSingleProfile()
    {
        return $this->hasOne(BusinessProfile::class);
    }

    public function businessProfileForRepresentative()
    {
        return $this->hasOne(BusinessProfile::class,'representative_user_id', 'id');
    }


    public function businessProfileWithTrashed()
    {
        return $this->hasMany(BusinessProfile::class)->withTrashed();
    }






}
