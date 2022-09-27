<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessProfile;
use Illuminate\Http\Request;

class ManageBusinessProfileController extends Controller
{

    public function delete($id)
    {
        $business_profile=BusinessProfile::findOrFail($id);
        $business_profile->delete();
        return redirect()->back()->with('success', 'business profile deactivated successfull');
    }

    public function restore($id)
    {
        $business_profile=BusinessProfile::onlyTrashed()
        ->where('id', $id)
        ->first();

        $business_profile->restore();
        return redirect()->back()->with('success', 'business profile restored successfull');
    }




}
