<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chamber;
use App\Models\Member;
use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Slot;
use App\Models\Week;
use  DateTime;
use App\Models\Appointment;
use App\Models\Family;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{


  public function appointment(Request $request) {
      
      $service = Service::where('service_status',1)->orderBy('service_name','asc')->get();
      $member_id = $request->query('member_id','');
      $date= date("Y-m-d");
      $week= date('l');
      
      if($member_id) {
            $member = Member::where('id',$member_id)->where('member_status',1)->first();
            $family=Family::where('status',1)->where('member_id',$member_id)->get();
       }else{
            $member=array();
            $family=array();
       }

      return view('admin.appointment',['service'=>$service,'member'=>$member,
         'member_id'=>$member_id,'family'=>$family]);

     }



     public function appointment_search(Request $request) { 

      $search_name = $request->search_name;

      $member = Member::where('registration',$search_name)->orWhere('phone',$search_name)->first();
     
    
    if (!$member) {
        return response()->json([
            'status' => 'fail',
            'message' => "Invalid Information",
        ],200);
    } else {
        return response()->json([
           'status' => 'success',
           'message' => "Vail Information",
           'member_id' =>$member->id,
        ],200);
   
    }    
    
}


     public function appointment_update(Request $request) { 
      
          $member_id = $request->member_id;
          $careof_id = $request->careof_id;
    
              $date= date("Y-m-d");
              $year= date("Y");
              $month= date("m");
              $day= date("d");
              $week= date('l');
              $auth=Auth::user();
         
            $validator = \Validator::make(
            $request->all(),
              [
                'member_id'=> 'required',
                'disease_problem'=> 'required',
                'careof_id'=> 'required',
                'service_name' =>'required',
                'room' =>'required',
             ]);

            //  return $request->all();
            //  die();

        if ($validator->fails()) {
            return response()->json([
                'status' =>400,
                'message' =>$validator->messages(),
            ]);
        } else {

            if($careof_id=='MySelf'){
                 $member=Member::find($member_id);
                 $date= date("Y-m-d");
                 $date1 = new DateTime($date);
                 $date2 = new DateTime($member->dobirth);
                 $yearDifference = getYearsBetween2Dates($date1, $date2, false);
                 $gender=$member->gender;
                
            }else{
                 $family=Family::find($careof_id);
                 $date= date("Y-m-d");
                 $date1 = new DateTime($date);
                 $date2 = new DateTime($family->dobirth);
                 $yearDifference = getYearsBetween2Dates($date1, $date2, false);
                 $gender=$family->gender;
            }
                
            $model = new Appointment;
            $model->service_name = $request->service_name;
            $model->room = $request->room;
            $model->member_id = $member_id;
            $model->disease_problem = $request->disease_problem;
            $model->week_name = $week;
            $model->gender = $gender;
            $model->age = $yearDifference;
            $model->date = $date;
            $model->month = $month;
            $model->year = $year;
            $model->day = $day;
            $model->created_by = $auth->id;
            $model->appointment_category = "Offline";
            $model->appointment_status = 1;

            if($careof_id=='MySelf'){}else{
                $model->careof_id  = $careof_id;
            }
            $model->save();
         
             return response()->json([
                 'status' => 200,
                 'message' => "Data saved successfully",
                 'appointment_id' =>$model->id,
             ]);
          

           
           }   
         
    }


    
       
     
}
