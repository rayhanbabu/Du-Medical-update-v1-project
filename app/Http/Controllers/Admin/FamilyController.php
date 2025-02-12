<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Member;
use App\Models\Family;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FamilyController extends Controller
{
    public function family(Request $request,$member_id){

        $member=Member::find($member_id);
        if ($request->ajax()) {
             $data = Family::leftjoin('members','members.id','=','families.member_id')
             ->where('families.member_id',$member_id)
             ->select('members.member_name','members.registration','members.phone','families.*')->latest()->get();
             return Datatables::of($data)
                ->addIndexColumn()
               
               ->addColumn('status', function($row){
                 $statusBtn = $row->status == '1' ? 
                     '<button class="btn btn-success btn-sm">Active</button>' : 
                     '<button class="btn btn-secondary btn-sm" >Inactive</button>';
                 return $statusBtn;
               })
                ->addColumn('edit', function($row){
                   $btn = '<a href="/admin/family/manage/'.$row->member_id.'/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                   return $btn;
               })
               ->addColumn('delete', function($row){
                 $btn = '<a href="/admin/family/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>';
                 return $btn;
             })
               ->rawColumns(['status','edit','delete'])
               ->make(true);
            }
          return view('admin.family',['member_id'=>$member_id,'member'=>$member]);  
      }


      public function family_manage(Request $request, $member_id='',$id=''){

           $result['member']=DB::table('members')->where('id',$member_id)->where('member_category','Employee')->orderBy('member_name','asc')->first();
           if($id>0){
               $arr=Family::where(['id'=>$id])->get();
               $result['id']=$arr['0']->id;
               $result['member_id']=$arr['0']->member_id;
               $result['family_member_name']=$arr['0']->family_member_name;
               $result['status']=$arr['0']->status;
               $result['relation_type']=$arr['0']->relation_type;
               $result['dobirth']=$arr['0']->dobirth;
               $result['gender']=$arr['0']->gender;
          } else {
              $result['id']='';
              $result['member_id']='';
              $result['family_member_name']='';
              $result['status']='';
              $result['relation_type']='';
              $result['dobirth']='';
              $result['gender']='';
          }

            return view('admin.family_manage',$result);  
        }

      public function family_insert(Request $request)
      {
          if(!$request->input('id')){
              $request->validate([
                 'family_member_name' => 'required',
                 'status' => 'required',
                 'member_id' => 'required',
               ]);
          }else{
              $request->validate([
                 'family_member_name' => 'required',
                 'status' => 'required',
                 'member_id' => 'required',
              ]);
          }

      $user=Auth::user();      
      if($request->post('id')>0){
          $model=Family::find($request->post('id'));
          $model->updated_by=$user->id;
      }else{
           $model= new Family; 
           $model->created_by=$user->id;
       }

        $model->family_member_name=$request->input('family_member_name');
        $model->member_id=$request->input('member_id');
        $model->status=$request->input('status');
        $model->relation_type=$request->input('relation_type');
        $model->gender=$request->input('gender');
        $model->dobirth=$request->input('dobirth');
        $model->save();

        return redirect('/admin/family/'.$model->member_id)->with('success', 'Changes saved successfully.');
        
      }


      public function family_delete(Request $request,$id){  
            $model=Family::find($id);
            $model->delete();
            return back()->with('success', 'Data deleted successfully.');
       }

}
