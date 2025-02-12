<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Service;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function service(Request $request){
        if ($request->ajax()) {
             $data = Service::latest()->get();
             return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                  $imageUrl = asset('uploads/admin/'.$row->image); // Assuming 'image' is the field name in the database
                  return '<img src="'.$imageUrl.'" alt="Image" style="width: 50px; height: 50px;"/>';
                })
               ->addColumn('status', function($row){
                 $statusBtn = $row->service_status == '1' ? 
                     '<button class="btn btn-success btn-sm">Active</button>' : 
                     '<button class="btn btn-secondary btn-sm" >Inactive</button>';
                 return $statusBtn;
               })
                ->addColumn('edit', function($row){
                   $btn = '<a href="/admin/service/manage/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                   return $btn;
               })
               ->addColumn('delete', function($row){
                 $btn = '<a href="/admin/service/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>';
                 return $btn;
             })
               ->rawColumns(['image','status','edit','delete'])
               ->make(true);
            }
          return view('admin.service');  
      }


      public function service_manage(Request $request, $id=''){
           if($id>0){
               $arr=Service::where(['id'=>$id])->get();
               $result['id']=$arr['0']->id;
               $result['service_name']=$arr['0']->service_name;
               $result['service_status']=$arr['0']->service_status;
          } else {
              $result['id']='';
              $result['service_name']='';
              $result['service_status']='';
          }

            return view('admin.service_manage',$result);  
        }

      public function service_insert(Request $request)
      {
    
          if(!$request->input('id')){
              $request->validate([
                 'service_name' => 'required|regex:/^[\w]*$/|unique:services,service_name',
                 'service_status' => 'required',
                 'image' =>'image|mimes:jpeg,png,jpg|max:500',
               ],
               [
                'service_name.regex' => 'The name must not contain spaces or hyphens.',
               ]);
          }else{
              $request->validate([
                 'service_name' => 'required|regex:/^[\w]*$/|unique:services,service_name,'.$request->post('id'),
                 'service_status' => 'required',
                 'image' =>'image|mimes:jpeg,png,jpg|max:500',
              ],
              [
                'service_name.regex' => 'The name must not contain spaces or hyphens.',
              ]
            );
          }

        $user=Auth::user();
      if($request->post('id')>0){
          $model=Service::find($request->post('id'));
          if($request->hasfile('image')){
            $path=public_path('uploads/admin/').$model->image;
             if(File::exists($path)){
                 File::delete($path);
              }

            $image= $request->file('image');
            $file_name = 'image'.rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/admin'), $file_name);
            $model->image=$file_name;
          }
          $model->updated_by=$user->id;
      }else{
           $model= new Service; 
           if($request->hasfile('image')){
            $image= $request->file('image');
            $file_name = 'image'.rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/admin'), $file_name);
            $model->image=$file_name;
          }
           $model->created_by=$user->id;
       }
         $model->service_name=$request->input('service_name');
         $model->service_status=$request->input('service_status');
         $model->save();

      
         return redirect('/admin/service')->with('success', 'Changes saved successfully.');

      }


      public function service_delete(Request $request,$id){
            
         $model=Service::find($id);
         $model->delete();
         return back()->with('success', 'Data deleted successfully.');

       }

}
