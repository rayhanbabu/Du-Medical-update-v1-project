<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notice;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;
use App\Models\Service;
use App\Models\Chamber;
use App\Models\Slot;
use App\Models\Staffduty;
use Illuminate\Support\Facades\URL;

  class HomeApiController extends Controller
  {
     
       public function page_detail(Request $request){
           $page_id=$request->page_id;
           $data=Notice::where('pagecategory_id',$page_id)->orderBy('serial','asc')->get();
           return response()->json([
                'status'=>'success',
                'data'=>$data 
            ],200);
       }


         public function serviceSchedule(Request $request){
             $service_table=Service::where('service_status',1)->orderBy('id','asc')->get()->toArray();
             $staff_duty = User::whereIn('userType', ['Nursing','Pharmacy','Staff'
              ,'Driver','Ward'])->select('userType')->groupBy('userType')->orderBy('id', 'asc')->get();
             
             $staff_duty1 = $staff_duty->map(function($staff_duty){
                 return [
                   'service_name' => $staff_duty->userType,
                   'userType' => $staff_duty->userType,
                 ];
             })->toArray();

             $mergedData = array_merge($service_table, $staff_duty1);
              return response()->json([
                   'status'=>'success',
                   'data'=>$mergedData 
               ],200);
        }


       public function serviceScheduleDetail(Request $request,$service_name){


         $chamber = Chamber::leftJoin('users', 'users.id', '=', 'chambers.user_id')
            ->where('service_name',$service_name)
            ->select('users.name', 'chambers.*' )->get();

           

        if($chamber->count()>0){

            $results = $chamber->map(function($chamber){
                return [
                   'id' => $chamber->id,
                   'service_name' => $chamber->service_name,
                   'name' => $chamber->name,
                   'Saturday' => slot_time($chamber->user_id,$chamber->id,'Saturday'),
                   'Sunday' => slot_time($chamber->user_id,$chamber->id,'Sunday'),
                   'Monday' => slot_time($chamber->user_id,$chamber->id,'Monday'),
                   'Tuesday' => slot_time($chamber->user_id,$chamber->id,'Tuesday'),
                   'Wednesday' => slot_time($chamber->user_id,$chamber->id,'Wednesday'),
                   'Thursday' => slot_time($chamber->user_id,$chamber->id,'Thursday'),
                   'Friday' => slot_time($chamber->user_id,$chamber->id,'Friday'),
                ];
            });

         }else{      
            $user = User::where('userType',$service_name)->orderBy('id', 'asc')->get();
            $results = $user->map(function($user){
                return [
                   'id' => $user->id,
                   'service_name' => $user->userType,
                   'name' => $user->name,
                   'Saturday' => staff_duty($user->id,'Saturday'),
                   'Sunday' => staff_duty($user->id,'Sunday'),
                   'Monday' => staff_duty($user->id,'Monday'),
                   'Tuesday' => staff_duty($user->id,'Tuesday'),
                   'Wednesday' => staff_duty($user->id,'Wednesday'),
                   'Thursday' => staff_duty($user->id,'Thursday'),
                   'Friday' => staff_duty($user->id,'Friday'),
                ];
            });

         }
              
         return response()->json([
            'status'=>'success',
            'data'=>$results 
       ],200);
           
     }



       public function teamMember(Request $request ,$member){
             if($member=="Doctor"){
                $doctor=User::where('userType','Doctor')->orderBy('id','asc')->get();
             }else{
                $doctor = User::whereIn('userType', ['Nursing','Pharmacy','Staff'
                ,'Homeopathy','Driver','Test','Ward','Pathologist'])->orderBy('id', 'asc')->get();
             }  
             
              return response()->json([
                  'status'=>'success',
                   'data'=>$doctor 
              ],200);
             
        }

     
        public function page_detail_by_id(Request $request, $id){
             $data=Notice::where('id',$id)->orderBy('id','asc')->first();
             return response()->json([
               'status'=>'success',
                'data'=>$data 
           ],200);
         }


   
    
   }
