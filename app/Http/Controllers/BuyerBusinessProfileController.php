<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuyerBusinessProfileController extends Controller
{
    
    public function index($alias){
        return view('new_business_profile.buyer_profile.index',compact('alias'));
    }

    public function rfqs($alias){
        return view('new_business_profile.buyer_profile.rfqs',compact('alias'));
    }

    public function myRfqs($alias){
        return view('new_business_profile.buyer_profile.my_rfqs',compact('alias'));
    }

    public function profomaPendingOrders($alias){
        return view('new_business_profile.buyer_profile.proforma_orders',compact('alias'));
    }

    public function profomaOngoingOrders($alias){
        return view('new_business_profile.buyer_profile.proforma_orders',compact('alias'));
    }

    public function profomaShippedOrders($alias){
        return view('new_business_profile.buyer_profile.proforma_orders',compact('alias'));
    }

    public function developmentCenter($alias){
        return view('new_business_profile.buyer_profile.development_center',compact('alias'));
    }

    public function orderManagement($alias){
        return view('new_business_profile.buyer_profile.order_management',compact('alias'));
    }

    public function products($alias){
        return view('new_business_profile.buyer_profile.products',compact('alias'));
    }

    public function profileInsights($alias){
        return view('new_business_profile.buyer_profile.profile_insights',compact('alias'));
    }
    
    public function profileHome($alias){
        return view('new_business_profile.buyer_profile.profile_home',compact('alias'));
    }
}
