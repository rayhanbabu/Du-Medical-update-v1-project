<?php

namespace App\Http\Controllers\MemberPanel;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\DB;
use App\Helpers\MemberJWTToken;
use App\Models\Chamber;
use App\Models\Member;
use App\Models\Service;
use  DateTime;
use App\Models\Slot;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use Exception;

class MemberPanelController extends Controller
{

    public function service_search(Request $request)
    {
         try {            
               $service_name = $request->query('service_name','');
               $date = $request->query('date', '');
               $week = date('l', strtotime($date)); 

               $current_date= date("Y-m-d");
               $hours = getHoursBetween2Dates(new DateTime($date), new DateTime($current_date),false);
               $member_id = $request->header('member_id');
               $member=Member::find($member_id);
          
      if($hours<0){
          return back()->with('fail', 'Invalid Date'); 
      }else{
        if($service_name && $date) {
            if($member->member_category="Student"){
            $chamber_detail=Slot::leftJoin('chambers','chambers.id', '=', 'slots.chamber_id')
              ->where('slot_status',1)->where('chambers.service_name',$service_name)
              ->where('slots.week_name',$week)->where('slots.slot_type','Online')
              ->whereIn('chambers.chamber_type', [$member->gender,'Both'])
              ->select('chambers.id',DB::raw('max(chambers.chamber_name) as chamber_name'))
              ->groupBy('chambers.id')->orderBy('chambers.id','asc')->get();
              $chamber_id = $request->query('chamber_id',$chamber_detail->min('id'));
            }else{
                $chamber_detail=Slot::leftJoin('chambers','chambers.id', '=', 'slots.chamber_id')
                 ->where('slot_status',1)->where('chambers.service_name',$service_name)
                 ->where('slots.week_name',$week)->where('slots.slot_type','Online')
                 ->select('chambers.id',DB::raw('max(chambers.chamber_name) as chamber_name'))
                 ->groupBy('chambers.id')->orderBy('chambers.id','asc')->get();
                $chamber_id = $request->query('chamber_id',$chamber_detail->min('id'));
             }
        }else{
            $chamber_detail=array();
            $chamber_id = $request->query('chamber_id','');
          }
         
         return view('member.service',['date'=>$date,'service_name'=>$service_name,'week'=>$week
           ,'chamber_id'=>$chamber_id,'chamber_detail'=>$chamber_detail]);
        }

          } catch(Exception $e) {
              return  view('errors.error',['error' => $e]);
          }
    }


    public function appointment_cart(Request $request,$slot_id,$date) {
        $slot_id=$slot_id;
        $date = $date;
        $year= date("Y",strtotime($date));
        $month= date("m",strtotime($date));
        $day= date("d",strtotime($date));
        $week= date('l',strtotime($date));
        
        $member_id = $request->header('member_id');

           $slot=Slot::leftJoin('chambers','chambers.id','=','slots.chamber_id')
           ->where('slot_status',1)->where('slots.id',$slot_id)
           ->where('slots.week_name',$week)->select('chambers.service_name','chambers.user_id',
           'chambers.chamber_type','chambers.room','chambers.id as chamber_id','slots.*')->first();

             $current_time = date('Y-m-d H:i:s');
             $time =strtotime(date('H:i'));
             $booking_last_time=strtotime($slot->booking_last_time);
             $appoinment_pending=Appointment::where("appointment_category","Online")->where("confirm_status",0)->get();
             
              foreach($appoinment_pending as $row){
                 $minutes = getMinutesBetween2Dates(new DateTime($current_time), new DateTime($row->created_at), false) + 1;
                 if($minutes>1){ $model=Appointment::find($row->id)->delete(); } 
               }

           $appoinment_detail=Appointment::where("service_name",$slot->service_name)->where("week_name",$week)
            ->where("date",$date)->where("slot_id",$slot_id)->get();

          if($appoinment_detail->count()>0){
             return response()->json([
                  'status' => 400,
                  'message' => 'Slot Already Booked',
            ]);
           }else if($time-$booking_last_time>0){
               return response()->json([
                    'status' => 400,
                    'message' => 'Time Over',
                ]);   
           }else{  
              $model = new Appointment;
              $model->chamber_id  = $slot->chamber_id;
              $model->week_name   = $slot->week_name;
              $model->service_name   = $slot->service_name;
              $model->slot_id   = $slot->id;
              $model->chamber_type   = $slot->chamber_type;
              $model->duty_type   = $slot->duty_type;
              $model->slot_time   = $slot->slot_time;
              $model->member_id = $member_id;
              $model->room  = $slot->room;
              $model->date  = $date;
              $model->month   = $month;
              $model->year  = $year;
              $model->day  = $day;
             
              $model->appointment_category  = $slot->slot_type;
              $model->save();

              return response()->json([
                    'status' => 200,
                    'slot' => $model,
                    'message' => 'Data Fatch Successfully',
               ]);
            }
        }



        public function appointment_delete(Request $request,$appointment_id){
                $appointment_id=$appointment_id;
                $model=Appointment::find($appointment_id);
                $model->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'Data Fatch Successfully',
                ]);
          }




          public function appointment_update(Request $request) { 

              $appointment_id = $request->appointment_id;
              $disease_problem = $request->disease_problem;
              $appointment = Appointment::find($appointment_id);
          if(!$appointment_id ||  !$disease_problem ) {
               return response()->json([
                   'status' => 400,
                   'message' => "Please select a slot, provide patient information, and describe the disease problem.",
                ]);
          }else{
            $member=Member::find($appointment->member_id);
            $date= date("Y-m-d");
            $date1 = new DateTime($date);
            $date2 = new DateTime($member->dobirth);
            $yearDifference = getYearsBetween2Dates($date1, $date2, false);
            $gender=$member->gender;
              
             $slot=Slot::leftJoin('chambers','chambers.id','=','slots.chamber_id')
              ->where('slot_status',1)->where('slots.id',$appointment->slot_id)
              ->select('chambers.service_name','chambers.user_id',
              'chambers.chamber_type','chambers.room','chambers.id as chamber_id','slots.*')->first();
              
            if($slot->chamber_type==$gender || $slot->chamber_type=='Both'){ 
                       $model = Appointment::find($appointment_id);
              if($model){
                    $model->member_id = $appointment->member_id;
                    $model->disease_problem = $disease_problem;
                    $model->confirm_status=1;
                    $model->gender =$gender;
                    $model->age =$yearDifference;
                    $model->update();
                  
                    return response()->json([
                        'status' => 200,
                        'message' => "Data saved successfully",
                    ]);
              } else {
                    return response()->json([
                        'status' => 404,
                        'message' => "Appointment not found",
                    ]);
               }
             }else{
                    return response()->json([
                         'status' => 400,
                         'message' => "This Slot Choice only ".$slot->chamber_type,
                    ]); 
             }
          }      
       }
 


 }
