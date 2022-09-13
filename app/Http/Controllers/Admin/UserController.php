<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessProfile;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SubscribedUserEmail;
use DataTables;
class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('is_representative', false);
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('email', function($row) {
                       $route= route('user.show', $row->id);
                       $action='<a href="'.$route.'">'.$row->email.'</a>';
                       return $action;
                    })
                    ->editColumn('created_at', function ($user) {
                        return \Carbon\Carbon::parse($user->created_at)->isoFormat('MMMM Do YYYY');
                    })
                    ->orderColumn('name', function ($query) {
                        $query->orderBy('created_at', 'desc');
                    })
                    ->rawColumns(['email'])
                    ->make(true);
        }

        return view('admin.users.index');
    }

    public function show($id)
    {
        $user=User::where('id', $id)->with('businessProfileWithTrashed')->first();

        if(!$user)
        {
            abort(404);
        }
        return view('admin.users.show',compact('user'));
    }

    public function businessProfileDetails($profile_id)
    {
        $business_profile=BusinessProfile::withTrashed()->where('id', $profile_id)->with('companyOverview','machineriesDetails','categoriesProduceds','productionCapacities','productionFlowAndManpowers','certifications','mainbuyers','exportDestinations','associationMemberships','pressHighlights','businessTerms','samplings','specialCustomizations','sustainabilityCommitments','walfare','security')->first();
        if(!$business_profile)
        {
            abort(404);
        }
        return view('admin.users.business_profile_details', compact('business_profile'));
    }

    public function verifiedUserRequestList()
    {
        $users = User::where('is_request_verified', 0)->get();
        //dd($users);

        return view('admin.users.verification_user', compact('users'));
    }

    public function updateUserVerificationRequest(Request $request)
    {

        $user = User::where("id", $request->id)->first();
        $user->is_request_verified = 1;
        $user->save();

        //$users = User::where('is_request_verified', 0)->get();

        //return view('admin.users.verification_user', compact('users'));
        return response()->json(["status" => 1, "message" => "successful"]);
    }

    public function exportSubscribedUsersEmail()
    {

        $subscribedUsersList = SubscribedUserEmail::latest()->get();
        $data = [];
        foreach($subscribedUsersList as $item) {
            array_push($data, $item->newsletter_email_address);
        }

        $handle = fopen("subscribed_users.csv", "w");
        //fwrite($handle, json_encode($data));
        fputcsv($handle, $data);
        fclose($handle);

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename('subscribed_users.csv'));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('subscribed_users.csv'));
        readfile('subscribed_users.csv');

        //return view('admin.users.verification_user', compact('users'));
        return response()->json(["status" => 1, "message" => "successful", "data" => $data]);
    }


}
