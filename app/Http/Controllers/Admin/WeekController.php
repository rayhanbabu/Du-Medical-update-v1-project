<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Week;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class WeekController extends Controller
{
    public function week(Request $request){
        if ($request->ajax()) {
             $data = Week::latest()->get();
             return Datatables::of($data)
                ->addIndexColumn()
               
               ->addColumn('status', function($row){
                 $statusBtn = $row->week_status == '1' ? 
                     '<button class="btn btn-success btn-sm">Active</button>' : 
                     '<button class="btn btn-secondary btn-sm" >Inactive</button>';
                 return $statusBtn;
               })
                ->addColumn('edit', function($row){
                   $btn = '<a href="/admin/week/manage/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                   return $btn;
               })
               ->addColumn('delete', function($row){
                 $btn = '<a href="/admin/week/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>';
                 return $btn;
             })
               ->rawColumns(['status','edit','delete'])
               ->make(true);
            }
          return view('admin.week');  
      }


      public function week_manage(Request $request, $id=''){
           if($id>0){
               $arr=Week::where(['id'=>$id])->get();
               $result['id']=$arr['0']->id;
               $result['week_name']=$arr['0']->week_name;
               $result['week_status']=$arr['0']->week_status;
          } else {
              $result['id']='';
              $result['week_name']='';
              $result['week_status']='';
          }

            return view('admin.week_manage',$result);  
        }

      public function week_insert(Request $request)
      {
    
          if(!$request->input('id')){
              $request->validate([
                 'week_name' => 'required|regex:/^[\w]*$/|unique:weeks,week_name',
                 'week_status' => 'required',
               ],
               [
                'week_name.regex' => 'The name must not contain spaces or hyphens.',
               ]);
          }else{
              $request->validate([
                 'week_name' => 'required|regex:/^[\w]*$/|unique:weeks,week_name,'.$request->post('id'),
                 'week_status' => 'required',
              ],
              [
                'week_name.regex' => 'The name must not contain spaces or hyphens.',
              ]
            );
          }

        $user=Auth::user();
      if($request->post('id')>0){
          $model=Week::find($request->post('id'));
          $model->updated_by=$user->id;
      }else{
           $model= new Week; 
           $model->created_by=$user->id;
       }
         $model->week_name=$request->input('week_name');
         $model->week_status=$request->input('week_status');
         $model->save();

         return back()->with('success', 'Changes saved successfully.');

      }


      public function week_delete(Request $request,$id){
            
         $model=Week::find($id);
         $model->delete();
         return back()->with('success', 'Data deleted successfully.');

       }

}
