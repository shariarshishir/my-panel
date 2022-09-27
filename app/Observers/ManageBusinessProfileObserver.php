<?php

namespace App\Observers;

use App\Models\BusinessProfile;

class ManageBusinessProfileObserver
{

    protected static $relations_to_cascade_to_wholesaler = ['cartItems','wholesalerProducts','relatedProducts'];
    protected static $relations_to_cascade_to_manufacture = ['manufactureProducts'];

    protected static $relations_to_cascade_to_wholesaler_restore = ['cartItems','wholesalerProducts','relatedProducts'];
    protected static $relations_to_cascade_to_manufacture_restore  = ['manufactureProducts'];
    /**
     * Handle the BusinessProfile "created" event.
     *
     * @param  \App\Models\BusinessProfile  $businessProfile
     * @return void
     */
    public function created(BusinessProfile $businessProfile)
    {
        //
    }

    /**
     * Handle the BusinessProfile "updated" event.
     *
     * @param  \App\Models\BusinessProfile  $businessProfile
     * @return void
     */
    public function updated(BusinessProfile $businessProfile)
    {
        //
    }

    /**
     * Handle the BusinessProfile "deleted" event.
     *
     * @param  \App\Models\BusinessProfile  $businessProfile
     * @return void
     */
    public function deleted(BusinessProfile $businessProfile)
    {
        if($businessProfile->business_type == "manufacturer") {
                $relations_to_cascade =static::$relations_to_cascade_to_manufacture;
            }else{
                $relations_to_cascade =static::$relations_to_cascade_to_wholesaler;
            }
            foreach ($relations_to_cascade as $relation) {
                foreach ($businessProfile->{$relation}()->get() as $item) {
                    if(isset($item)){
                        $item->delete();
                    }
                    if($relation == 'wholesalerProducts' ){
                        if($item->productWishLists()->exists()){
                            $item->productWishLists()->delete();
                        }
                    }

                }
            }

    }

    /**
     * Handle the BusinessProfile "restored" event.
     *
     * @param  \App\Models\BusinessProfile  $businessProfile
     * @return void
     */
    public function restored(BusinessProfile $businessProfile)
    {
        if($businessProfile->business_type == "manufacturer") {
            $relations_to_cascade =static::$relations_to_cascade_to_manufacture_restore;
        }else{
            $relations_to_cascade =static::$relations_to_cascade_to_wholesaler_restore;
        }
        foreach ($relations_to_cascade as $relation) {
            foreach ($businessProfile->{$relation}()->onlyTrashed()->get() as $item) {
                if(isset($item)){
                    $item->restore();
                }
                if($relation == 'wholesalerProducts' ){
                    if($item->productWishLists()->onlyTrashed()->exists()){
                        $item->productWishLists()->onlyTrashed()->restore();
                    }
                }
            }
        }
    }

    /**
     * Handle the BusinessProfile "force deleted" event.
     *
     * @param  \App\Models\BusinessProfile  $businessProfile
     * @return void
     */
    public function forceDeleted(BusinessProfile $businessProfile)
    {
        //
    }
}
