<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

class NewUserRequestController extends Controller
{

    public function index(Request $request, $type)
    {
        if ($request->ajax()) {
            $is_supplier=$type=='buyer' ? 0 : 1;
            $data = User::with(['countryName'])->where('is_supplier', $is_supplier)->where('is_representative', false)->select('*');
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('country', function($row){
                        if($row->countryName){
                            return $row->countryName->name;
                        }
                    })
                    ->addColumn('action', function($row){
                       if($row->is_email_verified == true){
                           return 'active';
                       }
                       return 'Inactive';
                    })
                    ->editColumn('created_at', function ($user) {
                        return \Carbon\Carbon::parse($user->created_at)->isoFormat('MMMM Do YYYY');
                    })
                    ->addColumn('edit', function($row){
                        $route= route('new.user.request.edit', $row->id);
                        $action='<a href="'.$route.'"><i class="fas fa-edit"></i></a>';
                        return $action;
                    })
                    ->orderColumn('phone', function ($query, $order) {
                        $query->orderBy('created_at','desc');
                    })
                    ->rawColumns(['edit'])
                    ->make(true);
        }

        return view('admin.new_user_request.index', compact('type'));
    }

    public function edit($id)
    {
        $user=User::with('countryName')->findOrFail($id);
        return view('admin.new_user_request.edit', compact('user'));
    }

    public function update($id){
        $user=User::findOrFail($id);
        if($user->is_email_verified == false){
            $user->update(['is_email_verified' => true ]);
            return redirect()->back()->withSuccess('User updated');
        }
        $user->update(['is_email_verified' => false ]);
        return redirect()->back()->withSuccess('User updated');
    }
}


