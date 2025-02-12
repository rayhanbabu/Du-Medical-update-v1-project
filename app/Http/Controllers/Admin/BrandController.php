<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Brand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function brand(Request $request){
        if ($request->ajax()) {
             $data = Brand::latest()->get();
             return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $statusBtn = $row->brand_status == '1' ? 
                        '<button class="btn btn-success btn-sm">Active</button>' : 
                        '<button class="btn btn-secondary btn-sm">Inactive</button>';
                     return $statusBtn;
                 })
                 ->addColumn('edit', function($row){
                   $btn = '<a href="/admin/brand/manage/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                   return $btn;
               })
               ->addColumn('delete', function($row){
                 $btn = '<a href="/admin/brand/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>';
                 return $btn;
             })
               ->rawColumns(['status','edit','delete'])
               ->make(true);
            }
          return view('admin.brand');  
      }


      public function brand_manage(Request $request, $id=''){
           if($id>0){
               $arr=Brand::where(['id'=>$id])->get();
               $result['id']=$arr['0']->id;
               $result['brand_name']=$arr['0']->brand_name;
               $result['brand_status']=$arr['0']->brand_status;
          } else {
              $result['id']='';
              $result['brand_name']='';
              $result['brand_status']='';
          }

            return view('admin.brand_manage',$result);  
        }

      public function brand_insert(Request $request)
      {
    
          if(!$request->input('id')){
              $request->validate([
                 'brand_name' => 'required|unique:brands,brand_name',
                 'brand_status' => 'required',
               ]);
          }else{
              $request->validate([
                 'brand_name' => 'required|unique:brands,brand_name,'.$request->post('id'),
                 'brand_status' => 'required',
              ]);
          }

        $user=Auth::user();
      if($request->post('id')>0){
          $model=Brand::find($request->post('id'));
          $model->updated_by=$user->id;
      }else{
           $model= new Brand; 
           $model->created_by=$user->id;
       }
         $model->brand_name=$request->input('brand_name');
         $model->brand_status=$request->input('brand_status');
         $model->save();

         return redirect('/admin/brand')->with('success', 'Changes saved successfully.');

      }


      public function brand_delete(Request $request,$id){          
         $model=Brand::find($id);
         $model->delete();
         return back()->with('success','Data deleted successfully.');

       }

}
