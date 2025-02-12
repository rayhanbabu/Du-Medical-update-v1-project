<?php
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Mail;
    use App\Models\Appointment;
    use App\Models\Generic;
    use Illuminate\Support\Facades\Cookie;
    use Illuminate\Support\Facades\Auth;
    use App\Models\Medicine;
    use App\Models\Member;
    use App\Models\User;
    use App\Models\Testprovide;
    use App\Models\Testreport;
    use App\Models\Pagecategory;
    use App\Models\Chamber;
    use App\Models\Staffduty;
    use App\Models\Slot;

       function prx($arr){
           echo "<pre>";
           print_r($arr);
           die();
       }

       function SendEmail($email,$subject,$body,$otp,$name){
          $details = [
               'subject'=> $subject,
               'otp_code'=>$otp,
               'body'=>$body,
               'name'=>$name,
           ];
           Mail::to($email)->send(new \App\Mail\LoginMail($details));
       }


        function member_info(){
              $member_info=Cookie::get('member_info');
              $result=unserialize($member_info);
              return $result;
         }


       function appointmentDetail($serviceName, $slotId) {

            $date = date("Y-m-d");
            $week = date('l');
            $appointmentDetail = Appointment::where("service_name", $serviceName)
                                    ->where("week_name", $week)
                                    ->where("date", $date)
                                    ->where("slot_id", $slotId)
                                    ->first();
             return $appointmentDetail ? $appointmentDetail->slot_id : null;
      }


      function slotbychamber($chamber_id,$slot_type,$week) {

        $data = Slot::leftJoin('chambers','chambers.id','=','slots.chamber_id')
        ->where('chamber_id',$chamber_id)->where('slot_type',$slot_type)
        ->where('week_name', $week)->select('chambers.service_name','slots.*')->orderBy('serial','asc')->get();
          return $data;         
      }

      function getMinutesBetween2Dates(DateTime $date1, DateTime $date2, $absolute = true) {
         $interval = $date2->diff($date1);
         $minutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
         return (!$absolute and $interval->invert) ? -$minutes : $minutes;
      }

      function getYearsBetween2Dates(DateTime $date1, DateTime $date2, $absolute = true) {
          $interval = $date2->diff($date1);
          $years = $interval->y;
          return (!$absolute && $interval->invert) ? -$years : $years;
      }

      function getHoursBetween2Dates(DateTime $date1, DateTime $date2, $absolute = true) {
        $interval = $date2->diff($date1);
        $hours = ($interval->days * 24) + $interval->h;  // Calculate total hours
        return (!$absolute and $interval->invert) ? -$hours : $hours;
    }

     $familyFunction=function ($member_id){
            return $member_id;
        };

        $diagnosticFunction=function($test_id){
            return $test_id;
        };

      function mediceine($medicime_id){
          $data = Medicine::where('id', $medicime_id)->first();
          return $data;
      }

      function generic_name($generic_id){
         $data = Generic::where('id', $generic_id)->first();
         return $data->generic_name;
     }



       function admin_info(){
           $result=Auth::user();
           return $result;
       }

        function admin_access(){               
            if (!empty(admin_info()->userType) && admin_info()->userType == "Admin") {
                return true;
            } else {
                return false;
            }
          }
 
        function doctor_access(){               
          if (!empty(admin_info()->userType) && (admin_info()->userType == "Doctor" || admin_info()->userType == "Admin")){
                 return true;
           }else{
                return false;
            }       
         }


           function nursing_access(){               
            if(!empty(admin_info()->userType) && (admin_info()->userType=="Nursing" OR admin_info()->userType=="Admin")){
                  return true;
              }else{
                 return false;
              }       
            }


        function pharmacy_access(){               
            if(!empty(admin_info()->userType) && (admin_info()->userType=="Pharmacy" OR admin_info()->userType=="Admin")){
                 return true;
             }else{
                return false;
             }       
          }


             function diagnostic_access(){               
                if(!empty(admin_info()->userType) && (admin_info()->userType=="Test" OR admin_info()->userType=="Pathologist" OR admin_info()->userType=="Admin")){
                     return true;
                  }else{
                    return false;
                 }       
            }


              function ward_access(){               
                 if(!empty(admin_info()->userType) && (admin_info()->userType=="Ward" OR admin_info()->userType=="Admin")){
                       return true;
                  }else{
                      return false;
                  }       
              }



            function driver_access(){               
                if(!empty(admin_info()->userType) && (admin_info()->userType=="Driver" OR admin_info()->userType=="Admin")){
                       return true;
                 }else{
                      return false;
                }       
            }


        function registration_access(){               
                if(!empty(admin_info()->userType) && (admin_info()->userType=="Admin")){
                      return true;
                }else if(!empty(admin_info()->userType) && (admin_info()->userType=="Staff" && admin_info()->offline_reg_access=="Yes")){
                     return true;
                }else{
                    return false;
                }       
           }


        function report_access(){               
             if(!empty(admin_info()->userType) && admin_info()->userType=="Admin"){
                return true;
             }else if(!empty(admin_info()->userType) && (admin_info()->userType=="Staff" && admin_info()->reports_access=="Yes")){
                 return true;
             }else{
                  return false;
             }       
        }


        function patient_report_access(){               
             if(!empty(admin_info()->userType) && admin_info()->userType=="Admin"){
                   return true;
              }else if(!empty(admin_info()->userType) && (admin_info()->userType=="Staff" && admin_info()->patient_report_access=="Yes")){
                   return true;
              }else{
                   return false;
              }       
         }


         function oncall_access(){               
              if(!empty(admin_info()->userType) && admin_info()->userType=="Admin"){
                   return true;
              }else if(!empty(admin_info()->userType) && (admin_info()->userType=="Staff" && admin_info()->oncall_access=="Yes")){
                   return true;
              }else{
                   return false;
              }       
          }



          function test_id_access($valuesArray,$test_id,$userType){
                if($userType=="Admin"){
                      return true;
                }else{
                  foreach($valuesArray as $value){
                      if($value==$test_id){
                           return true;
                        }
                    }
                 } 
            }
          


           function member_name($member_id){
                $data = Member::where('id', $member_id)->first();
                return $data?$data:"";
           }

           function user_name($user_id){
             $data = User::where('id', $user_id)->first();
             return $data?$data:"";
           }



          function test_report($appointment_id,$testcategory_id){
              $testprovide_show = Testprovide::leftjoin('tests','tests.id','=','testprovides.test_id')
              ->leftjoin('testcategories','testcategories.id','=','tests.testcategory_id')
              ->where('testprovides.appointment_id',$appointment_id)
              ->where('tests.testcategory_id',$testcategory_id)
              ->select('tests.testcategory_id','tests.test_name','testprovides.*')->get();
             return $testprovide_show;
          }

       function character_report($testprovide_id){
          $data = Testreport::leftjoin('characters','characters.id','=','testreports.character_id')
          ->where('testprovide_id',$testprovide_id)
          ->select('testreports.character_id'
          ,DB::raw("Max(characters.character_name) as character_name")
          ,DB::raw("Max(testreports.testprovide_id) as testprovide_id")
          )->groupBy('testreports.character_id')->get();
          return $data;
        }

          function diagnostic_report($testprovide_id,$character_id){
             $testreport = Testreport::leftjoin('diagnostics','diagnostics.id','=','testreports.diagnostic_id')
             ->where('testprovide_id',$testprovide_id)->where('testreports.character_id',$character_id)
             ->select('diagnostics.diagnostic_name','testreports.*')->get();
              return $testreport;
          }


          function test_report_status($appointment_id){
              $data = Testprovide::where('appointment_id',$appointment_id)->get();

              if($data->count()==0){
                 return "empty";
              }else if($data->count()==$data->sum('test_status')){
                 return "completed";
              }else{
                 return "processing";
              } 
        }


        function page_cagetory(){
            $data = Pagecategory::where('pagecategory_status',1)->get();
            return $data?$data:"";
          }


       function slot_time($user_id,$chamber_id,$week_name){
             $slot = Chamber::leftJoin('users','users.id', '=', 'chambers.user_id')
             ->leftJoin('slots','slots.chamber_id', '=', 'chambers.id')
             ->leftJoin('dutytimes','dutytimes.duty_type', '=', 'slots.duty_type')
             ->where('chambers.user_id',$user_id)->where('chambers.id',$chamber_id)->where('slots.week_name',$week_name)
             ->select('slots.week_name','slots.duty_type','dutytimes.duty_time')->first();
             return $slot?$slot->duty_time:"";
        }


      function  user_type(){
          $data = User::whereIn('userType', ['Nursing','Pharmacy','Staff'
         ,'Driver','Ward'])->select('userType')->groupBy('userType')->orderBy('id', 'asc')->get();
         return $data;
      }


      function  user_detail($userType){
          $user = User::where('userType',$userType)->orderBy('id', 'asc')->get();
          return $user;
      }


      function  staff_duty($user_id,$week_name){
         $data = Staffduty::where('user_id',$user_id)->where('week_name',$week_name)->orderBy('id', 'asc')->first();
         return $data?$data->duty_time:"";
     }


         
   ?>
