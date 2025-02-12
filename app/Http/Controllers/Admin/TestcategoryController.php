<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Testcategory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class TestcategoryController extends Controller
{
    public function testcategory(Request $request){
        if ($request->ajax()) {
             $data = Testcategory::latest()->get();
             return Datatables::of($data)
                ->addIndexColumn()
               
               ->addColumn('status', function($row){
                 $statusBtn = $row->testcategory_status == '1' ? 
                     '<button class="btn btn-success btn-sm">Active</button>' : 
                     '<button class="btn btn-secondary btn-sm" >Inactive</button>';
                 return $statusBtn;
               })
                ->addColumn('edit', function($row){
                   $btn = '<a href="/admin/testcategory/manage/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                   return $btn;
               })
               ->addColumn('delete', function($row){
                 $btn = '<a href="/admin/testcategory/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>';
                 return $btn;
             })
               ->rawColumns(['status','edit','delete'])
               ->make(true);
            }
          return view('admin.testcategory');  
      }


      public function testcategory_manage(Request $request, $id=''){
           if($id>0){
               $arr=Testcategory::where(['id'=>$id])->get();
               $result['id']=$arr['0']->id;
               $result['testcategory_name']=$arr['0']->testcategory_name;
               $result['testcategory_status']=$arr['0']->testcategory_status;
          } else {
              $result['id']='';
              $result['testcategory_name']='';
              $result['testcategory_status']='';
          }

            return view('admin.testcategory_manage',$result);  
        }

      public function testcategory_insert(Request $request)
      {
    
          if(!$request->input('id')){
              $request->validate([
                 'testcategory_name' => 'required|unique:testcategories,testcategory_name',
                 'testcategory_status' => 'required',
               ]);
          }else{
              $request->validate([
                 'testcategory_name' => 'required|unique:testcategories,testcategory_name,'.$request->post('id'),
                 'testcategory_status' => 'required',
              ]
            );
          }

        $user=Auth::user();
      if($request->post('id')>0){
          $model=Testcategory::find($request->post('id'));
          $model->updated_by=$user->id;
      }else{
           $model= new testcategory; 
           $model->created_by=$user->id;
       }
         $model->testcategory_name=$request->input('testcategory_name');
         $model->testcategory_status=$request->input('testcategory_status');
         $model->save();

         return redirect('/admin/testcategory')->with('success', 'Changes saved successfully.');

      }


      public function testcategory_delete(Request $request,$id){
            
         $model=Testcategory::find($id);
         $model->delete();
         return back()->with('success', 'Data deleted successfully.');

       }

}
