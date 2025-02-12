<?php

namespace App\Http\Controllers\WebCustomize;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Pagecategory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class PageCategoryController extends Controller
{
    public function pagecategory(Request $request){
        if ($request->ajax()) {
             $data = Pagecategory::latest()->get();
             return Datatables::of($data)
                ->addIndexColumn()
               
               ->addColumn('status', function($row){
                 $statusBtn = $row->pagecategory_status == '1' ? 
                     '<button class="btn btn-success btn-sm">Active</button>' : 
                     '<button class="btn btn-secondary btn-sm" >Inactive</button>';
                 return $statusBtn;
               })
                ->addColumn('edit', function($row){
                   $btn = '<a href="/admin/pagecategory/manage/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                   return $btn;
               })
               ->addColumn('delete', function($row){
                 $btn = '<a href="/admin/pagecategory/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>';
                 return $btn;
             })
               ->rawColumns(['status','edit','delete'])
               ->make(true);
            }
          return view('webcustomize.pagecategory');  
      }


      public function pagecategory_manage(Request $request, $id=''){
           if($id>0){
               $arr=Pagecategory::where(['id'=>$id])->get();
               $result['id']=$arr['0']->id;
               $result['page_name']=$arr['0']->page_name;
               $result['page_id']=$arr['0']->page_id;
               $result['pagecategory_status']=$arr['0']->pagecategory_status;
          } else {
              $result['id']='';
              $result['page_name']='';
              $result['page_id']='';
              $result['pagecategory_status']='';
          }

            return view('webcustomize.pagecategory_manage',$result);  
        }

      public function pagecategory_insert(Request $request)
      {
    
          if(!$request->input('id')){
            $request->validate([
              'page_id' => [
                  'required', 
                  'string', 
                  'regex:/^\S.*$/',  // Ensures no spaces at all
                  'unique:pagecategories,page_id'
              ],
              'pagecategory_status' => 'required',
              'page_name' => 'required',
          ], [
              'page_id.regex' => 'The page ID must not contain spaces or hyphens.',
          ]);
       }else{
          $request->validate([
            'page_id' => [
                 'required', 
                 'string', 
                 'regex:/^\S.*$/',  // Ensures no spaces at all
                 'unique:pagecategories,page_id,' . $request->post('id')
             ],
            'pagecategory_status' => 'required',
            'page_name' => 'required',
          ], [
            'page_id.regex' => 'The page ID must not contain spaces or hyphens.',
          ]);
        }

        $user=Auth::user();
      if($request->post('id')>0){
          $model=Pagecategory::find($request->post('id'));
          $model->updated_by=$user->id;
      }else{
           $model= new Pagecategory; 
           $model->created_by=$user->id;
       }
         $model->page_id=$request->input('page_id');
         $model->page_name=$request->input('page_name');
         $model->pagecategory_status=$request->input('pagecategory_status');
         $model->save();

      
         return redirect('/admin/pagecategory')->with('success', 'Changes saved successfully.');

      }


      public function pagecategory_delete(Request $request,$id){
            
         $model=Pagecategory::find($id);
         $model->delete();
         return back()->with('success', 'Data deleted successfully.');

       }

}
