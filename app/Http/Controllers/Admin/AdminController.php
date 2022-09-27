<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Proforma;
use App\Models\SubscribedUserEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use DateTime;
use DateTimeZone;
use DateInterval;


class AdminController extends Controller
{
    public function __construct()
    {
      $this->middleware('is.admin',['except' => ['showLoginForm', 'login','logout']]);
    }
    public function dashboard()
    {
        // Total RFQs
        $response = Http::get(env('RFQ_APP_URL').'/api/quotation/status/all/filter/null/page/1/limit/10');
        $data = $response->json();
        $rfqs = $data['data'];
        $rfqsCount = $data['count'];

        // Total Quotations
        $suggestedSupplierResponse = Http::get(env('RFQ_APP_URL').'/api/supplier/suggested-supplier-count');
        $suggestedSupplierData = $suggestedSupplierResponse->json();
        $suggestedSupplierCount = $suggestedSupplierData['count'];

        // Proforma collection
        $proformaInvoices = Proforma::where('status', '=', 0)->get();
        $proformaInvoicesCount = count($proformaInvoices);

        // Purchase order collection
        $proformaOrders = Proforma::where('status', '=', 1)->get();
        $proformaOrdersCount = count($proformaOrders);

        //dd($notifications);

        return view('admin.dashboard.dashboard',compact('rfqs','rfqsCount','suggestedSupplierCount', 'proformaInvoicesCount', 'proformaOrdersCount'));
    }

    public function showLoginForm()
    {
        return view('admin.login');
    }
    public function login(Request $request)
    {

        $request->validate([
        'email'    => 'required|email|exists:admins|min:5|max:191',
        'password' => 'required|string|min:4|max:255',
       ]);
       if(Auth::guard('admin')->attempt($request->only('email','password'),$request->filled('remember'))){
            Auth::guard('admin')->user()->update(['fcm_token'=>$request->fcm_token]);
            //dd($post_url);
            Http::post(env('RFQ_APP_URL').'/api/token-register', [
                'user_id' => 5771,
                'fcmtoken' => $request->fcm_token,
            ]);

            return redirect()
                ->route('admin.dashboard')
                ->with('status','You are Logged in as Admin!');
        }
        return redirect()
        ->route('admin.showLoginForm')
        ->withInput()
        ->withErrors('Login failed, please try again!');


    }


    public function logout()
        {
            Auth::guard('admin')->logout();
            return redirect()->route('admin.showLoginForm')->with('message','Admin has been logged out!');;
        }

    public function monthlyRegisteredUsers(Request $request)
    {
        //dd($request->all());
		$statsYear = $request->stats_year;
		$statsMonth = $request->stats_month;
		$allMonth = $request->all_month;
        $timezone ="Asia/Dhaka";

		$statsFrom = $request->stats_from;
		$statsTo = $request->stats_to;

        $monthNames = array('01' => 'Jan',
                        '02' => 'Feb',
                        '03' => 'Mar',
                        '04' => 'Apr',
                        '05' => 'May',
                        '06' => 'Jun',
                        '07' => 'Jul',
                        '08' => 'Aug',
                        '09' => 'Sep',
                        '10' => 'Oct',
                        '11' => 'Nov',
                        '12' => 'Dec',
                    );

        $totalUsers = 0;
        $barCategories = $barData = array();

        if($statsFrom!="" && $statsTo!="")
        {
            $rangeStart = $statsFrom;
            $rangeEnd = $statsTo;
        }
        else
        {
            if($allMonth==1){ // All month
                //print $statsMonth;
                $tmp = explode(',', $statsMonth);

                $d = new DateTime($statsYear.$tmp[0].'01', new DateTimeZone($timezone));
                $rangeStart = $d->format('Y-m-d');

                $d = new DateTime($statsYear.$tmp[count($tmp)-1].'01', new DateTimeZone($timezone));
                $rangeEnd = $d->format('Y-m-t');
            }
            else {
                $d = new DateTime($statsYear.$statsMonth.'01', new DateTimeZone($timezone));
                $rangeStart = $d->format('Y-m-d');
                $rangeEnd = $d->format('Y-m-t');
            }
        }

        if($allMonth==0)
        {
            $oStart = new DateTime($rangeStart, new DateTimeZone($timezone));
            $oEnd = clone $oStart;
            $oEnd->add(new DateInterval("P1M"));

            while ($oStart->getTimestamp() < $oEnd->getTimestamp()) {
                $k = $oStart->format('Ymd');
                $barData[$k] = 0;
                $barCategories[] = $oStart->format('M d');
                $oStart->add(new DateInterval("P1D"));
            }
        }

        //$rows = User::get();
        $rows = User::where('created_at', '>=', $rangeStart)->where('created_at', '<=', $rangeEnd)->get();
        //dd($rows);
        $totalUsers = count($rows);

        if(!empty($rows))
        {
            foreach($rows as $row)
            {
                if($allMonth==1)
                {
                    $tmp = explode(',', $statsMonth);
                    //dd($row);
                    $tmpDateObj = new DateTime($row->created_at, new DateTimeZone($timezone));

                    foreach($tmp as $v)
                    {
                        if($tmpDateObj->format('m')==$v )
                        {
                            if(isset($barData[$v])){
                                $tmp = $barData[$v];
                                $barData[$v] = $tmp+1;
                            }
                            else {
                                $barData[$v] = 1;
                            }
                        }
                        if(!isset($barData[$v])){
                            $barData[$v] = 0;
                        }
                    }
                    if(!empty($barData))
                    {
                        foreach($barData as $k => $v)
                        {
                            $barCategories[$k] = $monthNames[$k];
                        }
                    }
                }
                else { // if a month is selected, we have to show date range specific data
                    $tmpDateObj = new DateTime($row->created_at, new DateTimeZone($timezone));

                    //foreach($barCategories as $k => $v){
                        //$tmpArr = explode('-', $v);
                        //if($tmpDateObj->format('d')>=$tmpArr[0] && $tmpDateObj->format('d')<=$tmpArr[1] ){
                            //if(isset($barData[$v])){
                                //$tmp = $barData[$v];
                                //$barData[$v] = $tmp+1;
                            //}
                            //else {
                                //$barData[$v] = 1;
                            //}
                        //}
                        //if(!isset($barData[$v])){
                            //$barData[$v] = 0;
                        //}
                    //}

                    foreach($barData as $k => $v)
                    {
                        if($tmpDateObj->format('Ymd')==$k){
                            $tmp = $v;
                            $v = $tmp+1;
                        }

                        $barData[$k] = $v;
                    }
                }

                //echo '<pre>';
                //print_r($barCategories);
                //print_r($barData);
            }
        }
        else {
            if($allMonth==1)
            {
                $tmp = explode(',', $statsMonth);

                foreach($tmp as $v){
                    $barData[$v] = 0;
                }
                if(!empty($barData)){
                    foreach($barData as $k => $v){
                        $barCategories[$k] = $monthNames[$k];
                    }
                }
            }
        }

        //$json_result['error'] = 0;
        //$json_result['barCategories'] = array_values($barCategories);
        //$json_result['barData'] = array_values($barData);
        //$json_result['totalUsers'] = $totalUsers;
        //$json_result['msg'] = 'data collected successfully!';

        return response()->json(["error"=>0, "barCategories"=>array_values($barCategories), "barData"=>array_values($barData), "totalUsers"=>$totalUsers, "msg"=> "registered users data collected successfully!"]);
    }

    public function getUsersBasedOnSelectedParams(Request $request)
    {

        $selectedYear = $request->selectedYear;
        $selectedMonth = $request->selectedMonth;
        $timezone ="Asia/Dhaka";

        $d = new DateTime($selectedYear.$selectedMonth.'01', new DateTimeZone($timezone));
        $rangeStart = $d->format('Y-m-d');
        $rangeEnd = $d->format('Y-m-t');
        //$rows = User::whereBetween('created_at', [$rangeStart, $rangeEnd])->get();
        $rows = User::where('created_at', '>=', $rangeStart)->where('created_at', '<=', $rangeEnd)->get();
        $rowsCount = count($rows);
        $html = "";

        if(!empty($rows) && $rowsCount > 0)
        {
            $html .= '<table class="table table-bordered table-striped" cellpadding="0" cellspacing="0">';
            $html .=  '<thead class="cf">';
            $html .= '<tr>';
            $html .= '<th>Name</th>';
            $html .= '<th>Email</th>';
            $html .= '<th>Phone</th>';
            $html .= '<th>Company Name</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            foreach($rows as $row)
            {
                $html .= '<tr>';
                $html .= '<td data-title="Name">'.$row->name.'</td>';
                $html .= '<td data-title="Email">'.$row->email.'</td>';
                $html .= '<td data-title="Phone">'.$row->phone.'</td>';
                $html .= '<td data-title="Company Name">'.$row->company_name.'</td>';
                $html .= '</tr>';
            }
            $html .= '</tbody>';
            $html .= '</table>';
        }
        else
        {
            $html .= "No data found!";
        }

        return response()->json(["status"=>1, 'data'=>$html, 'datacount'=>$rowsCount, "message"=>"data collected successfully for selected month and year!"]);

    }

    public function lastTwoWeeksActivedUsers(Request $request)
    {
        //dd(Carbon::now()->subDays(14));
        //dd(Carbon::now());

        //$rangeStart = "2021-12-01";
        //$rangeEnd = "2021-12-14";

        $rangeStart = Carbon::now()->subDays(30)->format('Y-m-d');
        $rangeEnd = Carbon::now()->format('Y-m-d');

        $timezone ="Asia/Dhaka";
        $totalUsers = 0;
        $barCategories = $barData = array();

        $oStart = new DateTime($rangeStart, new DateTimeZone($timezone));
        $oEnd = clone $oStart;
        $oEnd->add(new DateInterval("P1M"));

        while ($oStart->getTimestamp() < $oEnd->getTimestamp()) {
            $k = $oStart->format('Ymd');
            $barData[$k] = 0;
            $barCategories[] = $oStart->format('M d');
            $oStart->add(new DateInterval("P1D"));
        }

        //$rows = User::whereBetween('last_activity', [$rangeStart, $rangeEnd])->get();
        $rows = User::where('last_activity', '>=', $rangeStart)->where('last_activity', '<=', $rangeEnd)->get();
        //dd($rows);
        //$rows = User::whereDate('last_activity','>=',Carbon::now()->subdays(30))->get();
        $totalUsers = count($rows);

        if(!empty($rows))
        {
            foreach($rows as $row)
            {
                $tmpDateObj = new DateTime($row->last_activity, new DateTimeZone($timezone));
                foreach($barData as $k => $v)
                {
                    if($tmpDateObj->format('Ymd')==$k){
                        $tmp = $v;
                        $v = $tmp+1;
                    }

                    $barData[$k] = $v;
                }

                //echo '<pre>';
                //print_r($barCategories);
                //print_r($barData);
            }
        }

        return response()->json(["error"=>0, "barCategories"=>array_values($barCategories), "barData"=>array_values($barData), "totalUsers"=>$totalUsers, "msg"=> "data collected successfully!"]);
    }

    public function getUsersBasedOnActivityParams(Request $request)
    {

        $rangeStart = Carbon::now()->subDays(30)->format('Y-m-d');
        $rangeEnd = Carbon::now()->format('Y-m-d');
        $timezone ="Asia/Dhaka";

        //$d = new DateTime($selectedYear.$selectedMonth.'01', new DateTimeZone($timezone));
        //$rangeStart = $d->format('Y-m-d');
        //$rangeEnd = $d->format('Y-m-t');
        //$rows = User::whereBetween('last_activity', [$rangeStart, $rangeEnd])->get();
        $rows = User::where('last_activity', '>=', $rangeStart)->where('last_activity', '<=', $rangeEnd)->get();
        $rowsCount = count($rows);
        $html = "";

        if(!empty($rows) && $rowsCount > 0)
        {
            $html .= '<table class="table table-bordered table-striped" cellpadding="0" cellspacing="0">';
            $html .=  '<thead class="cf">';
            $html .= '<tr>';
            $html .= '<th>Name</th>';
            $html .= '<th>Email</th>';
            $html .= '<th>Phone</th>';
            $html .= '<th>Company Name</th>';
            $html .= '<th>Last Activity</th>';
            $html .= '</tr>';
            $html .= '</thead>';
            $html .= '<tbody>';
            foreach($rows as $row)
            {
                $html .= '<tr>';
                $html .= '<td data-title="Name">'.$row->name.'</td>';
                $html .= '<td data-title="Email">'.$row->email.'</td>';
                $html .= '<td data-title="Phone">'.$row->phone.'</td>';
                $html .= '<td data-title="Company Name">'.$row->company_name.'</td>';
                $html .= '<td data-title="Last Activity">'.$row->last_activity.'</td>';
                $html .= '</tr>';
            }
            $html .= '</tbody>';
            $html .= '</table>';
        }
        else
        {
            $html .= "No data found!";
        }

        return response()->json(["status"=>1, 'data'=>$html, 'datacount'=>$rowsCount, "message"=>"data collected successfully!"]);

    }

    public function subscribeUserListForNewsletter()
    {

        $subscribedUserList = SubscribedUserEmail::latest()->get();

        return view('admin.subscribedusers.index',compact('subscribedUserList'));
    }

}
