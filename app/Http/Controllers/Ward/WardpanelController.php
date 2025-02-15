<?php
namespace App\Http\Controllers\Ward;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Appointment;
use App\Models\Testreport;
use App\Models\Ward;
use  DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WardpanelController extends Controller
{

    public function ward_list(Request $request){

       if($request->ajax()){

             $data = Ward::with('member')->with('appointment')->with('user')->with('careof')
             ->select('appointment_id',DB::raw("MAX(member_id) as member_id")
             ,DB::raw("MAX(user_id) as user_id") ,DB::raw("MAX(user_id) as user_id"))
              ->groupBy('wards.appointment_id')->latest()->get();

               return Datatables::of($data)
                 ->addIndexColumn()
               ->addColumn('status',function($row){
                  $statusBtn = $row->indoor_status == '1'? 
                      '<button class="btn btn-success btn-sm"> Completed </button>' : 
                      '<button class="btn btn-secondary btn-sm"> Inactive </button>';
                   return $statusBtn;
               })
               ->addColumn('edit', function($row){
                 $btn = '<a href="/ward/setup?appointment_id='.$row->appointment_id.'" class="edit btn btn-primary btn-sm">Edit/View</a>';
                 return $btn;
                })->rawColumns(['status','edit'])->make(true);
       }
          return view('ward.ward');  
       }


       public function ward_setup(Request $request){

        $appointment_id = $request->query('appointment_id','');
        if($appointment_id) {
          $appointment=Appointment::with('member')->with('careof')->where('appointments.id',$appointment_id)->first();
       }else{
          $appointment=null;
       }

       return view('ward.ward_setup',['appointment'=>$appointment,'appointment_id'=>$appointment_id]); 
      }



      public function ward_search(Request $request) { 
         
        $search_name = $request->search_name;
        $appointment = Appointment::where('id',$search_name)->first();
       
      if (!$appointment) {
          return response()->json([
              'status' => 'fail',
              'message' => "Invalid Information",
          ],200);
      } else {
          return response()->json([
             'status' => 'success',
             'message' => "Vail Information",
             'appointment_id' =>$appointment->id,
          ],200);
     
      }    
      
  }



         public function ward_insert(Request $request){
            $user=Auth::user();
            $validator = \Validator::make(
                $request->all(),
                  [
                    'appointment_id'=> 'required',
                  ]);
    
             $date_with_time = date("Y-m-d H:i:s");     
            if ($validator->fails()) {
                return response()->json([
                    'status' =>400,
                    'message' =>$validator->messages(),
                ]);
            } else {
               $date= date("Y-m-d");
               $year= date("Y");
               $month= date("m");
               $day= date("d");
  
                $model = new Ward;
                $model->isolation_status = "No";
                $model->appointment_id = $request->input('appointment_id');
                $model->member_id = $request->input('member_id');
                $model->comment = $request->input('comment');
                $model->disease = $request->input('disease');
                $model->ward_no = $request->input('ward_no');
                $model->bed_no = $request->input('bed_no');
                $model->admited_at =$date_with_time;
                $model->user_id=$user->id;
                $model->date = $date;
                $model->year = $year;
                $model->month = $month;
                $model->day = $day;
                $model->save();
    
                return response()->json([
                    'status' => 200,
                    'message' => 'Data Added Successfully',
                ]);
            }
        }
  
  
        public function ward_service(Request $request,$appointment_id){
           if ($request->ajax()) {
                $data = Ward::leftJoin('users','users.id','=','wards.user_id')
                 ->where('appointment_id',$appointment_id)
                 ->select('users.name','wards.*')->latest()->get();
                return Datatables::of($data)
                  ->addIndexColumn()
                  ->addColumn('edit', function($row){
                   $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm">Edit</a>';
                   return $btn;
                 })
                  ->addColumn('delete', function($row){
                     $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
                     return $btn;
                  })->rawColumns(['edit','delete'])
                   ->make(true);
             }
            return view('ward.ward_report');  
  
           }



           public function ward_edit(Request $request)
           {
               $id = $request->id;
               $data = Ward::find($id);
                  return response()->json([
                      'status' => 200,
                      'value' => $data,
                  ]);
           }
       
       
           public function ward_update(Request $request)
           {
                $user=Auth::user();
                $validator=\Validator::make($request->all(),[
                     'disease'=>'required',
                ]);

                $date_with_time = date("Y-m-d H:i:s");
       
               if ($validator->fails()) {
                   return response()->json([
                       'status' => 400,
                       'message' => $validator->messages(),
                   ]);
               } else {
                   $model = Ward::find($request->input('edit_id'));
                   if($model){
                       if($request->input('isolation_status')=="Yes"){
                          $model->isolation_status = $request->input('isolation_status');  
                          $model->released_at = $date_with_time;  
                          $model->stay_hour=getHoursBetween2Dates(new DateTime($model->admited_at), new DateTime($date_with_time), $absolute = true);
                        }
                       $model->comment = $request->input('comment');
                       $model->disease = $request->input('disease');
                       $model->ward_no = $request->input('ward_no');
                       $model->bed_no = $request->input('bed_no');
                       $model->updated_by=$user->id;
                       $model->update();
                          return response()->json([
                             'status' => 200,
                             'message' => 'Data Updated Successfully'
                           ]);
                   } else {
                       return response()->json([
                           'status' => 404,
                           'message' => 'Student not found',
                       ]);
                   }
               }
           }
       

  
  
           public function ward_delete(Request $request)
           {
               $model = Ward::find($request->input('id'));
               $model->delete();
                 return response()->json([
                     'status' => 200,
                     'message' => 'Data Deleted Successfully',
                 ]);
           }
  
  
             public function ward_status(Request $request,$type,$appointment_id){
                   if($type=='inactive'){
                      $status=1;
                   }else{
                      $status=0;
                   }

                  return back()->with('success','Status update Successfull');  
       
             }

   }