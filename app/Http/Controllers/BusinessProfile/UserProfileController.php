<?php

namespace App\Http\Controllers\BusinessProfile;

use App\Http\Controllers\Controller;
use App\Models\BusinessProfile;
use App\Models\CompanyFactoryTour;
use App\Models\Admin\Certification;
use App\Models\Country;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function profileInsights($alias)
    {
        $business_profile = BusinessProfile::withTrashed()->with('businessProfileVerification')->where('alias',$alias)->firstOrFail();
        if($business_profile->business_type == 'manufacturer') // manufacturer profile
        {
            $profileIncompleteValueCount = 0;
            $profileProgressValue = 0;
            if($business_profile->businessProfileVerification()->exists() && $business_profile->businessProfileVerification->company_overview == 1) {
                $profileProgressValue += 11;
                $profileIncompleteValueCount += 0;
            } else {
                $profileIncompleteValueCount += 1;
            }
            if($business_profile->businessProfileVerification()->exists() && $business_profile->businessProfileVerification->machinery_details == 1) {
                $profileProgressValue += 11;
                $profileIncompleteValueCount += 0;
            } else {
                $profileIncompleteValueCount += 1;
            }
            if($business_profile->businessProfileVerification()->exists() && $business_profile->businessProfileVerification->categories_produced == 1) {
                $profileProgressValue += 11;
                $profileIncompleteValueCount += 0;
            } else {
                $profileIncompleteValueCount += 1;
            }
            if($business_profile->businessProfileVerification()->exists() && $business_profile->businessProfileVerification->capacity_and_machineries == 1) {
                $profileProgressValue += 11;
                $profileIncompleteValueCount += 0;
            } else {
                $profileIncompleteValueCount += 1;
            }
            if($business_profile->businessProfileVerification()->exists() && $business_profile->businessProfileVerification->business_terms == 1) {
                $profileProgressValue += 11;
                $profileIncompleteValueCount += 0;
            } else {
                $profileIncompleteValueCount += 1;
            }
            if($business_profile->businessProfileVerification()->exists() && $business_profile->businessProfileVerification->sampling == 1) {
                $profileProgressValue += 11;
                $profileIncompleteValueCount += 0;
            } else {
                $profileIncompleteValueCount += 1;
            }
            if($business_profile->businessProfileVerification()->exists() && $business_profile->businessProfileVerification->special_customizations == 1) {
                $profileProgressValue += 11;
                $profileIncompleteValueCount += 0;
            } else {
                $profileIncompleteValueCount += 1;
            }
            if($business_profile->businessProfileVerification()->exists() && $business_profile->businessProfileVerification->sustainability_commitments == 1) {
                $profileProgressValue += 11;
                $profileIncompleteValueCount += 0;
            } else {
                $profileIncompleteValueCount += 1;
            }
            if($business_profile->businessProfileVerification()->exists() && $business_profile->businessProfileVerification->production_capacity == 1) {
                $profileProgressValue += 11;
                $profileIncompleteValueCount += 0;
            } else {
                $profileIncompleteValueCount += 1;
            }

            if($profileProgressValue == 99) {
                $profileProgressValue = 100;
            }
        } elseif($business_profile->business_type == 'wholesaler') // wholesaler profile
        {
            $profileProgressValue = 0;
            $profileIncompleteValueCount = 0;
            if($business_profile->businessProfileVerification()->exists() && $business_profile->businessProfileVerification->company_overview == 1) {
                $profileProgressValue += 100;
                $profileIncompleteValueCount += 0;
            } else {
                $profileIncompleteValueCount += 1;
            }
        } else // design_studio profile
        {
            $profileIncompleteValueCount = 0;
            $profileProgressValue = 0;
        }
        
        return view('new_business_profile.profile_insights',compact('alias', 'profileProgressValue', 'business_profile', 'profileIncompleteValueCount'));
    }

    public function profileHome($alias)
    {
        $business_profile = BusinessProfile::withTrashed()->with('companyOverview','machineriesDetails','categoriesProduceds','productionCapacities','productionFlowAndManpowers','certifications','mainbuyers','exportDestinations','associationMemberships','pressHighlights','businessTerms','samplings','specialCustomizations','sustainabilityCommitments','walfare','security')->where('alias',$alias)->firstOrFail();
        $companyFactoryTour = CompanyFactoryTour::with('companyFactoryTourImages','companyFactoryTourLargeImages')->where('business_profile_id',$business_profile->id)->first();
        $default_certification = Certification::get();
        $country = Country::pluck('name','id');

        if((auth()->id() == $business_profile->user_id) || (auth()->id() == $business_profile->representative_user_id))
        {
            return view('new_business_profile.profile_home', compact('business_profile', 'companyFactoryTour', 'alias', 'default_certification', 'country'));
        }
        abort(401);
    }

    public function profileEdit($alias)
    {
        $business_profile = BusinessProfile::withTrashed()->with('companyOverview','machineriesDetails','categoriesProduceds','productionCapacities','productionFlowAndManpowers','certifications','mainbuyers','exportDestinations','associationMemberships','pressHighlights','businessTerms','samplings','specialCustomizations','sustainabilityCommitments','walfare','security')->where('alias',$alias)->firstOrFail();
        $companyFactoryTour = CompanyFactoryTour::with('companyFactoryTourImages','companyFactoryTourLargeImages')->where('business_profile_id',$business_profile->id)->first();
        $default_certification = Certification::get();
        $country = Country::pluck('name','id');

        if((auth()->id() == $business_profile->user_id) || (auth()->id() == $business_profile->representative_user_id))
        {
            return view('new_business_profile.profile_edit', compact('business_profile', 'companyFactoryTour', 'alias', 'default_certification', 'country'));
        }
        abort(401);
    }
}
