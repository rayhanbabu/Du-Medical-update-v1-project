<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\User;
use App\Models\Service;
use App\Models\Chamber;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChamberController extends Controller
{
    public function chamber(Request $request){

        if ($request->ajax()) {
             $data = Chamber::leftjoin('users','users.id','=','chambers.user_id')
             ->leftjoin('services','services.service_name','=','chambers.service_name')
             ->select('users.name','services.service_name','chambers.*')->latest()->get();
             return Datatables::of($data)
                ->addIndexColumn()
               ->addColumn('status', function($row){
                 $statusBtn = $row->chamber_status == '1' ? 
                     '<button class="btn btn-success btn-sm">Active</button>' : 
                     '<button class="btn btn-secondary btn-sm" >Inactive</button>';
                 return $statusBtn;
               })
               ->addColumn('slot', function($row){
                   $btn = '<a href="/admin/slot/'.$row->id.'" class="edit btn btn-primary btn-sm">Slot Setup</a>';
                    return $btn;
               })
                ->addColumn('edit', function($row){
                    $btn = '<a href="/admin/chamber/manage/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                    return $btn;
               })
               ->addColumn('delete', function($row){
                  $btn = '<a href="/admin/chamber/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>';
                  return $btn;
              })
                ->rawColumns(['slot','status','edit','delete'])
                ->make(true);
             }
          return view('admin.chamber');  
      }


      public function chamber_manage(Request $request, $id=''){

           $result['user']=User::where('userType','Doctor')->orderBy('name','asc')->get();
           $result['service']=Service::orderBy('service_name','asc')->get();
           if($id>0){
               $arr=Chamber::where(['id'=>$id])->get();
               $result['id']=$arr['0']->id;
               $result['user_id']=$arr['0']->user_id;
               $result['service_name']=$arr['0']->service_name;
               $result['chamber_name']=$arr['0']->chamber_name;
               $result['chamber_status']=$arr['0']->chamber_status;
               $result['chamber_type']=$arr['0']->chamber_type;
               $result['room']=$arr['0']->room;
          } else {
              $result['id']='';
              $result['user_id']='';
              $result['service_name']='';
              $result['chamber_name']='';
              $result['chamber_status']='';
              $result['chamber_type']='';
              $result['room']='';
          }

            return view('admin.chamber_manage',$result);  
        }

      public function chamber_insert(Request $request)
      {
    
          if(!$request->input('id')){
              $request->validate([
                 'chamber_name' => 'required|unique:chambers,chamber_name',
                 'chamber_status' => 'required',
                 'user_id' => 'required',
                 'service_name' => 'required',
                 'chamber_type' => 'required',
                 'room' => 'required',
               ]);
          }else{
              $request->validate([
                 'chamber_name' => 'required|unique:chambers,chamber_name,'.$request->post('id'),
                 'chamber_status' => 'required',
                 'user_id' => 'required',
                 'service_name' => 'required',
                 'chamber_type' => 'required',
                 'room' => 'required',
              ]
            );
          }

        $user=Auth::user();

   
      if($request->post('id')>0){
          $model=Chamber::find($request->post('id'));
          $model->updated_by=$user->id;
      }else{
           $model= new Chamber; 
           $model->created_by=$user->id;
       }
         $model->chamber_name=$request->input('chamber_name');
         $model->service_name=$request->input('service_name');
         $model->user_id=$request->input('user_id');
         $model->chamber_type=$request->input('chamber_type');
         $model->chamber_status=$request->input('chamber_status');
         $model->room=$request->input('room');
         $model->save();

         return redirect('/admin/chamber')->with('success', 'Changes saved successfully.');

      }


      public function chamber_delete(Request $request,$id){
            
         $model=Chamber::find($id);
         $model->delete();
         return back()->with('success', 'Data deleted successfully.');

       }

}
