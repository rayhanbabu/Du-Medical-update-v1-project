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

class NursingpanelController extends Controller
{

    public function nursing_list(Request $request){
       if($request->ajax()){

            $data = Appointment::leftJoin('members','members.id','=','appointments.member_id')
            ->leftJoin('users', 'users.id', '=', 'appointments.user_id')
             ->leftJoin('families','families.id','=','appointments.careof_id')
            ->whereIn('appointments.nursing_status',['0','1'])
            ->select('families.family_member_name','users.name', 'members.member_name', 'members.registration', 'appointments.*')
            ->latest()
            ->get();


            return Datatables::of($data)
                 ->addIndexColumn()
               ->addColumn('status',function($row){
                  $statusBtn = $row->nursing_status == '1' ? 
                      '<button class="btn btn-success btn-sm">Completed</button>' : 
                      '<button class="btn btn-danger btn-sm" >Pending</button>';
                   return $statusBtn;
               })
               ->addColumn('edit', function($row){
                 $btn = '<a href="/nursing/nursing_report/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                 return $btn;
                })
               ->rawColumns(['status','edit'])
               ->make(true);
       }
          return view('nursing.nursing');  
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
              $data = Nursing::leftJoin('users','users.id','=','nursings.user_id')
              ->where('appointment_id',$appointment_id)
              ->select('users.name','nursings.*')->latest()->get();
              return Datatables::of($data)
               ->addIndexColumn()
               ->addColumn('delete', function($row){
                  $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
                  return $btn;
               })->rawColumns(['delete'])
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