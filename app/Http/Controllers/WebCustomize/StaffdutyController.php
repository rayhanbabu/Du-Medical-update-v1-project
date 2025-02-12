<?php
namespace App\Http\Controllers\WebCustomize;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Staffduty;
use App\Models\User;
use App\Models\Week;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StaffdutyController extends Controller
{
    public function staffduty(Request $request,$userType){

        if($request->ajax()) {
             $data= User::where('userType',$userType)
             ->select('users.name','users.id','users.userType')->latest()->get();
             return Datatables::of($data)
                ->addIndexColumn()           
                ->addColumn('edit', function($row){
                     $btn = '<a href="/admin/staffduty/manage/'.$row->userType.'/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                     return $btn;
               })
               ->rawColumns(['edit'])
               ->make(true);
            }

          return view('webcustomize.staffduty',['userType'=>$userType]);  
      }


      public function staffduty_manage(Request $request, $userType,$id){   
            $user=DB::table('users')->where('userType',$userType)->where('id',$id)->orderBy('id','asc')->first(); 
            $week=DB::table('weeks')->where('week_status',1)->orderBy('id','asc')->get();
            $arr=Staffduty::where('user_id',$user->id)->get();
            if($arr->count()>0){
                 $data_list=$arr;
                 $table="staffduties";
             }else{
                 $data_list=$week;
                 $table="weeks";
             } 

            return view('webcustomize.staffduty_manage',['data_list'=>$data_list,'user'=>$user,'table'=>$table]);  
        }

      public function staffduty_insert(Request $request)
      {
          if(!$request->input('id')){
              $request->validate([
                 'user_id' => 'required',
                 'userType' => 'required',
                 'duty_time' => 'required',
                 'week_name' => 'required',
               ]);
          }else{
              $request->validate([
                'user_id' => 'required',
                'userType' => 'required',
                'duty_time' => 'required',
                'week_name' => 'required',
              ]);
          }

          $user=Auth::user();
       
          $user_id = $request->post('user_id');
          $userType = $request->post('userType');
          $duty_time = $request->post('duty_time');
          $week_name = $request->post('week_name');
      
          foreach($week_name as $key => $val){
              Staffduty::updateOrCreate(['week_name'=>$week_name[$key],'user_id'=>$user_id],['week_name' => $week_name[$key]
               ,'duty_time' => $duty_time[$key] ,'userType'=>$userType ]);
          }

         return redirect('/admin/staffduty/'.$userType)->with('success', 'Changes saved successfully.');

      }


       public function staffduty_delete(Request $request,$id){  
            $model=Staffduty::find($id);
            $model->delete();
            return back()->with('success', 'Data deleted successfully.');
        }

}
