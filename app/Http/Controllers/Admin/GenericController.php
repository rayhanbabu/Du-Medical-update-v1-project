<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Generic;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GenericController extends Controller
{
    public function generic(Request $request){
        if ($request->ajax()) {
            $data=Generic::where('generic_status',1)->latest()->get();
             return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $statusBtn = $row->generic_status == '1' ? 
                        '<button class="btn btn-success btn-sm">Active</button>' : 
                        '<button class="btn btn-secondary btn-sm">Inactive</button>';
                     return $statusBtn;
                 })
                 ->addColumn('edit', function($row){
                   $btn = '<a href="/admin/generic/manage/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                   return $btn;
               })
               ->addColumn('delete', function($row){
                 $btn = '<a href="/admin/generic/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>';
                 return $btn;
             })
               ->rawColumns(['status','edit','delete'])
               ->make(true);
            }
          return view('admin.generic');  
      }


      public function generic_manage(Request $request, $id=''){
     
           if($id>0){
               $arr=Generic::where(['id'=>$id])->get();
               $result['id']=$arr['0']->id;
               $result['generic_name']=$arr['0']->generic_name;
               $result['generic_status']=$arr['0']->generic_status;
               $result['warning_value']=$arr['0']->warning_value;
          } else {
              $result['id']='';
              $result['generic_name']='';
              $result['generic_status']='';
              $result['warning_value']='';
          }

            return view('admin.generic_manage',$result);  
        }

      public function generic_insert(Request $request)
      {
    
          if(!$request->input('id')){
              $request->validate([
                 'generic_name' => 'required|unique:generics,generic_name',
                 'generic_status' => 'required',
                 'warning_value' => 'required|integer',
               ]);
          }else{
              $request->validate([
                 'generic_name' => 'required|unique:generics,generic_name,'.$request->post('id'),
                 'generic_status' => 'required',
                 'warning_value' => 'required|integer',
 
              ]);
          }

        $user=Auth::user();
      if($request->post('id')>0){
          $model=Generic::find($request->post('id'));
          $model->updated_by=$user->id;
          $model->generic_name=$request->input('generic_name');
          $model->generic_status=$request->input('generic_status');
          $model->warning_value=$request->input('warning_value');
          $model->save();

          return redirect('/admin/generic')->with('success', 'Changes saved successfully.');

      }else{

           $model= new Generic; 
           $model->created_by=$user->id;
           $model->generic_name=$request->input('generic_name');
           $model->generic_status=$request->input('generic_status');
           $model->warning_value=$request->input('warning_value');
           $model->save();

              return redirect('/admin/generic')->with('success', 'Changes saved successfully.');
       } 

      }


      public function generic_delete(Request $request,$id){          
         $model=Generic::find($id);
         $model->delete();
         return back()->with('success','Data deleted successfully.');

       }

}
