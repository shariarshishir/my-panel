<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\BusinessMappingTree;
use App\Http\Controllers\Controller;
use App\Models\BusinessProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BusinessMappingTreeController extends Controller
{
    public function index()
    {

        $businessMappingTree = BusinessMappingTree::all();
        $source = BusinessMappingTree::select('id', 'name', 'parent_id')->get()->toArray();
        $inArray = array();
        foreach($source as $key => $value)
        {
            $inArray[$key] = $value;
        }

        $outArray = array();
        $this->makeParentChildRelations($inArray, $outArray);

        $total_row = $businessMappingTree->count();
        return view('admin.business_mapping_tree.index',compact('outArray','total_row'));
    }

    /**
     * Show the form for creating a new reproductCategories.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $source = BusinessMappingTree::select('id', 'name','parent_id')->get()->toArray();
        $inArray = array();
        foreach($source as $key => $value)
        {
            $inArray[$key] = $value;
        }

        $outArray = array();
        $this->makeParentChildRelations($inArray, $outArray);

        $businessMappingTree = new BusinessMappingTree();
        return view('admin.business_mapping_tree.create',compact('businessMappingTree', 'outArray'));

    }

    /**
     * Store a newly created reproductCategories in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:business_mapping_trees,name',
            'parent_id'=>'nullable|integer'
        ]);

        $businessMappingTree=new BusinessMappingTree();
        $businessMappingTree->name=strtolower($request->name);
        $businessMappingTree->alias = $this->createAlias($request->name);
        $businessMappingTree->parent_id=$request->parent_id;
        $businessMappingTree->ip_address = $request->ip();
        $businessMappingTree->user_agent = $request->header('User-Agent');
        $businessMappingTree->created_by=Auth::guard('admin')->user()->id;
        $businessMappingTree->updated_by=NULL;
        $result=$businessMappingTree->save();
        if($result){
           Session::flash('success','BusinessMappingTree Added successfully!!!!');
        }
        return redirect()->route('admin.business-mapping-tree.index');

    }


    /**
     * Show the form for editing the specified reproductCategories.
     *
     * @param  \App\Models\BusinessMappingTree  $BusinessMappingTree
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $source = BusinessMappingTree::select('id', 'name', 'parent_id')->get()->toArray();
        $inArray = array();
        foreach($source as $key => $value)
        {
            $inArray[$key] = $value;
        }

        $outArray = array();
        $this->makeParentChildRelations($inArray, $outArray);

        $businessMappingTree = BusinessMappingTree::find($id);
        return view('admin.business_mapping_tree.edit',compact('businessMappingTree', 'outArray'));
    }

    /**
     * Update the specified reproductCategories in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BusinessMappingTree  $BusinessMappingTree
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:business_mapping_trees,name,'.$id,
            'parent_id'=>'nullable|integer'
        ]);


        $businessMappingTree = BusinessMappingTree::find($id);
        $businessMappingTree->name=strtolower($request->name);
        $businessMappingTree->alias = $this->createAlias($request->name);
        $businessMappingTree->parent_id=$request->parent_id;
        $businessMappingTree->ip_address = $request->ip();
        $businessMappingTree->user_agent = $request->header('User-Agent');
        $businessMappingTree->created_by=$businessMappingTree->created_by;
        $businessMappingTree->updated_by=Auth::guard('admin')->user()->id;
        $result=$businessMappingTree->save();
        if($result){
           Session::flash('success','BusinessMappingTree Updated successfully!!!!');
        }
        return redirect()->route('admin.business-mapping-tree.index');
    }

    /**
     * Remove the specified reproductCategories from storage.
     *
     * @param  \App\Models\BusinessMappingTree  $BusinessMappingTree
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $businessMappingTree=BusinessMappingTree::find($id);
        $name= $businessMappingTree->name;
        if($businessMappingTree->children()->exists()){
            Session::flash('error','Category Can not  Delete ,This Category Has Child');
            return redirect()->route('admin.business-mapping-tree.index');

        }
        if(BusinessProfile::where('business_type',$name)->first() || BusinessProfile::where('industry_type',$name)->first() || BusinessProfile::where('factory_type',$name)->first()){
            Session::flash('error','Category Can not  Delete ,This Category Has Business Profile');
            return redirect()->route('admin.business-mapping-tree.index');
        }
        $result=$businessMappingTree->delete();
        if($result){
            Session::flash('success','BusinessMappingTree deleted successfully!!!!');
        }
        return redirect()->route('admin.business-mapping-tree.index');

    }

    public function makeParentChildRelations(&$inArray, &$outArray, $currentParentId = 0) {
        if(!is_array($inArray)) {
            return;
        }

        if(!is_array($outArray)) {
            return;
        }

        foreach($inArray as $key => $tuple) {
            if($tuple['parent_id'] == $currentParentId) {
                $tuple['children'] = array();
                $this->makeParentChildRelations($inArray, $tuple['children'], $tuple['id']);
                $outArray[] = $tuple;
            }
        }
    }


    public function createAlias($name)
    {
        $alias=$this->removeSpecialCharacterFromAlais($name);
        return $this->checkExistsAlias($alias);
    }

    public function checkExistsAlias($alias)
    {
        $check_exists=BusinessMappingTree::where('alias', $alias)->first();
        if($check_exists){
            $create_array= explode('-',$alias);
            $last_key=array_slice($create_array,-1,1);
            $last_key_string=implode(' ',$last_key);
            if(is_numeric($last_key_string)){
                $last_key_string++;
                array_pop($create_array);
                array_push($create_array,$last_key_string);
            }else{
                array_push($create_array,1);
            }
            $alias=implode("-",$create_array);
            return $this->checkExistsAlias($alias);

        }

        return $alias;
    }

    public function removeSpecialCharacterFromAlais($alias)
    {
        $lowercase=strtolower($alias);
        $pattern= '/[^A-Za-z0-9\-]/';
        $preg_replace= preg_replace($pattern, '-', $lowercase);
        $single_hypen= preg_replace('/-+/', '-', $preg_replace);
        $alias= $single_hypen;
        return $alias;
    }
}
