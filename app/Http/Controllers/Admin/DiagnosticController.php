<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Test;
use App\Models\Diagnostic;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DiagnosticController extends Controller
{
    public function diagnostic(Request $request,$test_id){

        $test=Test::find($test_id);
        if ($request->ajax()) {
           $data= Diagnostic::leftjoin('tests','tests.id','=','diagnostics.test_id')
             ->leftjoin('characters','characters.id','=','diagnostics.character_id')
             ->where('diagnostics.test_id',$test_id)
             ->select('tests.test_name','characters.character_name','diagnostics.*')->latest()->get();
             return Datatables::of($data)
                ->addIndexColumn()           
                ->addColumn('status', function($row){
                     $statusBtn = $row->diagnostic_status == '1' ? 
                         '<button class="btn btn-success btn-sm">Active</button>' : 
                         '<button class="btn btn-secondary btn-sm" >Inactive</button>';
                    return $statusBtn;
                })
                ->addColumn('edit', function($row){
                     $btn = '<a href="/admin/diagnostic/manage/'.$row->test_id.'/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                     return $btn;
               })
                 ->addColumn('delete', function($row){
                   $btn = '<a href="/admin/diagnostic/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>';
                  return $btn;
               })
               ->rawColumns(['status','edit','delete'])
               ->make(true);
            }

          return view('admin.diagnostic',['test_id'=>$test_id,'test'=>$test]);  
      }


      public function diagnostic_manage(Request $request, $test_id,$id=''){   
           $result['test']=DB::table('tests')->where('id',$test_id)->orderBy('test_name','asc')->first(); 
           $result['character']=DB::table('characters')->where('character_status',1)->orderBy('character_name','asc')->get();
           if($id>0){
               $arr=diagnostic::where(['id'=>$id])->get();
               $result['id']=$arr['0']->id;
               $result['test_id']=$arr['0']->test_id;
               $result['character_id']=$arr['0']->character_id;
               $result['diagnostic_name']=$arr['0']->diagnostic_name;
               $result['diagnostic_status']=$arr['0']->diagnostic_status;
               $result['reference_range']=$arr['0']->reference_range;
          } else {
              $result['id']='';
              $result['diagnostic_name']='';
              $result['diagnostic_status']='';
              $result['test_id']='';
              $result['character_id']='';
              $result['reference_range']='';
          }

            return view('admin.diagnostic_manage',$result);  
        }

      public function diagnostic_insert(Request $request)
      {
          if(!$request->input('id')){
              $request->validate([
                 'diagnostic_name' => 'required|unique:diagnostics,diagnostic_name',
                 'diagnostic_status' => 'required',
                 'test_id' => 'required',
               ]);
          }else{
              $request->validate([
                 'diagnostic_name' => 'required|unique:diagnostics,diagnostic_name,'.$request->post('id'),
                 'diagnostic_status' => 'required',
                 'test_id' => 'required',
              ]);
          }

          $user=Auth::user();
      if($request->post('id')>0){
          $model=Diagnostic::find($request->post('id'));
          $model->updated_by=$user->id;
      }else{
           $model= new Diagnostic; 
           $model->created_by=$user->id;
       }
         $model->diagnostic_name=$request->input('diagnostic_name');
         $model->test_id=$request->input('test_id');
         $model->character_id=$request->input('character_id');
         $model->diagnostic_status=$request->input('diagnostic_status');
         $model->reference_range=$request->input('reference_range');
         $model->save();

         return redirect('/admin/diagnostic/'.$model->test_id)->with('success', 'Changes saved successfully.');

      }


       public function diagnostic_delete(Request $request,$id){  
            $model=Diagnostic::find($id);
            $model->delete();
            return back()->with('success', 'Data deleted successfully.');
        }

}
