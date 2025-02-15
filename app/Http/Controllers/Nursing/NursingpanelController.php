<?php
namespace App\Http\Controllers\Nursing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Appointment;
use App\Models\Nursing;
use App\Models\Testreport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NursingpanelController extends Controller
{

    public function nursing_list(Request $request){
       if($request->ajax()){

            $data = Nursing::with('member')->with('appointment')->with('user')->with('careof')
             ->select('appointment_id',DB::raw("MAX(member_id) as member_id")
             ,DB::raw("MAX(user_id) as user_id") ,DB::raw("MAX(user_id) as user_id"))
             ->groupBy('nursings.appointment_id')->latest()->get();


            return Datatables::of($data)
                 ->addIndexColumn()
               ->addColumn('status',function($row){
                  $statusBtn = $row->nursing_status == '1' ? 
                      '<button class="btn btn-success btn-sm">Completed</button>' : 
                      '<button class="btn btn-danger btn-sm" >Pending</button>';
                   return $statusBtn;
               })
               ->addColumn('edit', function($row){
                 $btn = '<a href="/nursing/setup?appointment_id='.$row->appointment_id.'" class="edit btn btn-primary btn-sm">Edit/View</a>';
                 return $btn;
                })
                
               ->rawColumns(['status','edit'])
               ->make(true);
       }
          return view('nursing.nursing');  
       }


       public function nursing_setup(Request $request){

            $appointment_id = $request->query('appointment_id','');
        
       
          if($appointment_id) {
            $appointment=Appointment::with('member')->with('careof')->where('appointments.id',$appointment_id)->first();
           }else{
            $appointment=null;
           }

           return view('nursing.nursing_setup',['appointment'=>$appointment,'appointment_id'=>$appointment_id]); 
     }

       public function nursing_search(Request $request) { 
         
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



       public function nursing_report(Request $request,$appointment_id){
           $appointment = Appointment::leftJoin('members','members.id','=','appointments.member_id')
             ->leftJoin('users','users.id','=','appointments.user_id')
             ->leftJoin('families','families.id','=','appointments.careof_id')
             ->where('appointments.id',$appointment_id)
             ->select('families.family_member_name','users.name','members.gender','members.member_name','members.registration','appointments.*')
             ->first();

            return view('nursing.nursing_report',[ 'appointment'=>$appointment]); 

         }


    public function nursing_insert(Request $request){
          $user=Auth::user();
          $validator = \Validator::make(
              $request->all(),
                [
                   'service_type'=> 'required',
                   'appointment_id'=> 'required',
                ]);
  
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

              $model = new Nursing;
              $model->service_type = $request->input('service_type');
              $model->appointment_id = $request->input('appointment_id');
              $model->member_id = $request->input('member_id');
              $model->comment = $request->input('comment');
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


      public function nursing_service(Request $request,$appointment_id){
         if ($request->ajax()) {
              $data = Nursing::with('user')->where('appointment_id',$appointment_id)->latest()->get();
              return Datatables::of($data)
               ->addIndexColumn()
               ->addColumn('delete', function($row){
                  $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
                  return $btn;
               })
               ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)
                    ->timezone('Asia/Dhaka')
                    ->format('Y-m-d H:i:s'); // Adjust format as needed
               })
               ->rawColumns(['delete'])
               ->make(true);
           }
          return view('nursing.nursing_report');  

         }


         public function nursing_delete(Request $request)
         {
             $model = Nursing::find($request->input('id'));
             $model->delete();
             return response()->json([
                 'status' => 200,
                 'message' => 'Data Deleted Successfully',
             ]);
         }


           public function nursing_status(Request $request,$type,$appointment_id){
                    if($type=='inactive'){
                        $status=1;
                    }else{
                        $status=0;
                    }
              
                 DB::update("update appointments set nursing_status ='$status' where id = '$appointment_id'" );  
                   return back()->with('success','Status update Successfull');  
     
            }
        
   }