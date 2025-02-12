<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Dutytime;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DutyTimeController extends Controller
{
    public function dutytime(Request $request){
        if ($request->ajax()) {
             $data = Dutytime::latest()->get();
             return Datatables::of($data)
                ->addIndexColumn()           
                ->addColumn('status', function($row){
                   $statusBtn = $row->duty_status == '1' ? 
                      '<button class="btn btn-success btn-sm">Active</button>' : 
                      '<button class="btn btn-secondary btn-sm" >Inactive</button>';
                  return $statusBtn;
                })
                ->addColumn('edit', function($row){
                    $btn = '<a href="/admin/dutytime/manage/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                    return $btn;
               })
                ->addColumn('delete', function($row){
                    $btn = '<a href="/admin/dutytime/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $btn;
               })
               ->rawColumns(['status','edit','delete'])
               ->make(true);
            }
          return view('admin.dutytime');  
      }


      public function dutytime_manage(Request $request, $id=''){

        
           if($id>0){
               $arr=Dutytime::where(['id'=>$id])->get();
               $result['id']=$arr['0']->id;
               $result['duty_time']=$arr['0']->duty_time;
               $result['duty_type']=$arr['0']->duty_type;
               $result['duty_status']=$arr['0']->duty_status;
               
          } else {
              $result['id']='';
              $result['duty_time']='';
              $result['duty_type']='';
              $result['duty_status']='';
          }

            return view('admin.dutytime_manage',$result);  
        }

      public function dutytime_insert(Request $request)
      {
    
          if(!$request->input('id')){
              $request->validate([
                 'duty_time' => 'required|unique:dutytimes,duty_time',
                 'duty_type' => 'required',
                 'duty_status' => 'required',
               ]);
          }else{
              $request->validate([
                 'duty_time' => 'required|unique:dutytimes,duty_time,'.$request->post('id'),
                 'duty_type' => 'required',
                 'duty_status' => 'required',
              ]
            );
          }

        $user=Auth::user();
        if($request->post('id')>0){
           $model=Dutytime::find($request->post('id'));
           $model->updated_by=$user->id;
        }else{
            $model= new Dutytime; 
            $model->created_by=$user->id;
        }

         $model->duty_time=$request->input('duty_time');
         $model->duty_type=$request->input('duty_type');
         $model->duty_status=$request->input('duty_status');
         $model->save();

         return redirect('/admin/dutytime')->with('success', 'Changes saved successfully.');

      }


      public function dutytime_delete(Request $request,$id){
            
         $model=Dutytime::find($id);
         $model->delete();
         return back()->with('success', 'Data deleted successfully.');

       }

}
