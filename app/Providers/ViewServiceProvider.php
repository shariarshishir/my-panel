<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ProductCategory;
use App\Models\ProductWishlist;
use App\Models\CartItem;
use Auth;
use App\Models\Config;
use App\Models\Manufacture\ProductCategory as ManufactureProductCategory;
use App\Models\ProductTag;
use App\Models\ProductTypeMapping;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //product tags
        view()->composer(['new_business_profile.manufacturer_products.index','new_business_profile.wholesaler_products.index','new_business_profile.create_rfq_modal','business_profile.show','business_profile._edit_modal_data','wholesaler_profile.products.index','product.details','product.manufactrue_product_details','rfq.create','rfq.create_from_product','rfq._create_rfq_form_modal','rfq._edit_rfq_modal','new_business_profile._product_filter', 'new_business_profile._rfq_filter', 'new_business_profile._rfq_filter_mobile', 'new_business_profile.business_profileinfo_edit._edit_company_overview_modal'], function($view){
            $product_tags=ProductTag::get(['id','name']);
            $view->with(['product_tags'=>$product_tags]);
        });

        //product type mapping
        view()->composer(['new_business_profile._product_filter','new_business_profile._product_filter_mobile', 'new_business_profile._rfq_filter', 'new_business_profile._rfq_filter_mobile'], function($view){
            $product_type_mapping=ProductTypeMapping::where('parent_id', '!=', null)->get(['id','title']);
            $view->with(['product_type_mapping'=>$product_type_mapping]);
        });

        view()->composer('include.admin._header', function($view) {
            if(auth()->guard('admin')->check()){
                $notifications =auth()->guard('admin')->user()->unreadNotifications->where('read_at',NULL);
                $response = Http::get(env('RFQ_APP_URL').'/api/notifications');
                $messageNotifications = $response->json();
                $view->with(['notifications'=>$notifications,'messageNotifications'=>$messageNotifications]);
            }
        });

        view()->composer('include._header', function($view) {
            if(auth()->check())
            {
                //$userNotifications =auth()->user()->unreadNotifications;
                //$view->with(['userNotifications'=>$userNotifications]);

                $userNotifications = auth()->user()->unreadNotifications->whereNotIn('type','App\Notifications\BuyerWantToContact')->where('read_at',NULL);
                $response = Http::get(env('RFQ_APP_URL').'/api/notifications/user/'.auth()->user()->sso_reference_id);
                $messageCenterNotifications = $response->json();
                $view->with(['userNotifications' => $userNotifications,'messageCenterNotifications' => $messageCenterNotifications]);
            }

        });

        //config
        view()->composer(['user.cart.checkout', 'order_success'], function($view){
            if(auth()->check())
            {
                $config=Config::first();
                if(isset($config)){
                    $configArray=[];
                    foreach( json_decode($config->config_data) as $key=>$data){
                        $configArray[$key]=$data;
                    }
                    $view->with(['configArray'=>$configArray]);
                }

            }
        });

        //wishlist data
        view()->composer(['manufacture_profile_view_by_user.index','wholesaler_profile_view_by_user.index'], function($view) {
            if(Auth()->check()){
                $wishListShopProductsIds=ProductWishlist::where('user_id' , auth()->user()->id)->where('product_id', '!=', null)->pluck('product_id')->toArray();
                $wishListMfProductsIds=ProductWishlist::where('user_id' , auth()->user()->id)->where('manufacture_product_id', '!=', null)->pluck('manufacture_product_id')->toArray();
            }
            else{
                $wishListShopProductsIds=[];
                $wishListMfProductsIds=[];
            }
            $view->with(['wishListShopProductsIds' => $wishListShopProductsIds, 'wishListMfProductsIds' => $wishListMfProductsIds]);

        });
    }


}
