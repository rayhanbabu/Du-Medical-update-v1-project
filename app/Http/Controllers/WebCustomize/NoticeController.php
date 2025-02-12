<?php

namespace App\Http\Controllers\WebCustomize;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Pagecategory;
use App\Models\Notice;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{
    public function notice(Request $request,$pagecategory_id){
        $pagecategory=Pagecategory::where('page_id',$pagecategory_id)->first();
        
        if ($request->ajax()){
           $data= Notice::leftjoin('pagecategories','pagecategories.page_id','=','notices.pagecategory_id')
             ->where('notices.pagecategory_id',$pagecategory_id)
             ->select('pagecategories.page_name','notices.*')->latest()->get();
             return Datatables::of($data)
                ->addIndexColumn()  
                ->addColumn('image', function($row){
                    $imageUrl = asset('uploads/admin/'.$row->image); // Assuming 'image' is the field name in the database
                    return '<img src="'.$imageUrl.'" alt="Image" style="width: 50px; height: 50px;"/>';
                  })         
                 ->addColumn('status', function($row){
                     $statusBtn = $row->notice_status == '1' ? 
                         '<button class="btn btn-success btn-sm">Active</button>' : 
                         '<button class="btn btn-secondary btn-sm" >Inactive</button>';
                    return $statusBtn;
                  })
                  ->addColumn('edit', function($row){
                      $btn = '<a href="/admin/notice/manage/'.$row->pagecategory_id.'/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                      return $btn;
                  })
                  ->addColumn('delete', function($row){
                    $btn = '<a href="/admin/notice/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>';
                   return $btn;
                 })
                 ->rawColumns(['image','status','edit','delete'])
                 ->make(true);
            }

          return view('webcustomize.notice',['pagecategory_id'=>$pagecategory_id,'pagecategory'=>$pagecategory]);  
      }


      public function notice_manage(Request $request, $pagecategory_id,$id=''){   
         $result['pagecategory']=DB::table('pagecategories')->where('page_id',$pagecategory_id)->orderBy('page_name','asc')->first();    
          if($id>0){
               $arr=notice::where(['id'=>$id])->get();
               $result['id']=$arr['0']->id;
               $result['date']=$arr['0']->date;
               $result['title']=$arr['0']->title;
               $result['notice_status']=$arr['0']->notice_status;  
               $result['serial']=$arr['0']->serial; 
               $result['link']=$arr['0']->link;  
               $result['short_desc']=$arr['0']->short_desc; 
               $result['desc']=$arr['0']->desc;            
          } else {
              $result['id']='';
              $result['date']='';
              $result['title']='';
              $result['notice_status']='';
              $result['serial']=''; 
              $result['link']='';  
              $result['short_desc']=''; 
              $result['desc']='';             

          }

            return view('webcustomize.notice_manage',$result);  
        }

      public function notice_insert(Request $request)
      {
          if(!$request->input('id')){
              $request->validate([
                 'title' => 'required|unique:notices,title',
                 'notice_status' => 'required',
                 'pagecategory_id' => 'required',
                 'image' =>'file|mimes:jpeg,png,jpg,pdf|max:600',
               ]);
          }else{
              $request->validate([
                 'title' => 'required|unique:notices,title,'.$request->post('id'),
                 'notice_status' => 'required',
                 'pagecategory_id' => 'required',
                 'image' =>'file|mimes:jpeg,png,jpg,pdf|max:600',
              ]);
          }

            $user=Auth::user();
        if($request->post('id')>0){
           $model=Notice::find($request->post('id'));
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
           $model= new Notice; 
           if($request->hasfile('image')){
            $image= $request->file('image');
            $file_name = 'image'.rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/admin'), $file_name);
            $model->image=$file_name;
          }
           $model->created_by=$user->id;
       }
         $model->title=$request->input('title');
         $model->pagecategory_id=$request->input('pagecategory_id');
         $model->notice_status=$request->input('notice_status');
         $model->link=$request->input('link');
         $model->short_desc=$request->input('short_desc');
         $model->desc=$request->input('desc');
         $model->serial=$request->input('serial',1);
         $model->date=$request->input('date');
         $model->save();

         return redirect('/admin/notice/'.$model->pagecategory_id)->with('success', 'Changes saved successfully.');

      }


       public function notice_delete(Request $request,$id){  
            $model=notice::find($id);
            $model->delete();
            return back()->with('success', 'Data deleted successfully.');
        }

}
