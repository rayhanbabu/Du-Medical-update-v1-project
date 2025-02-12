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

  class HomeController extends Controller
  {

     public function index(Request $request){
          $slider=Notice::where('pagecategory_id','SliderImage')->orderBy('serial','asc')->get();
          $welcome=Notice::where('pagecategory_id','WelcomeMessage')->orderBy('serial','asc')->first();
          $news=Notice::where('pagecategory_id','NewsEvent')->orderBy('serial','asc')->get();
       
          return view('home.home',['slider'=>$slider,'welcome'=>$welcome,'news'=>$news]);
      }


      public function service(Request $request){
            $service=Service::where('service_status',1)->orderBy('id','asc')->get();
            return view('home.service',['service'=>$service]);
       }

       public function doctor(Request $request ,$member){
             if($member=="Doctor"){
                $doctor=User::where('userType','Doctor')->orderBy('id','asc')->get();
             }else{
                $doctor = User::whereIn('userType', ['Nursing','Pharmacy','Staff'
                ,'Homeopathy','Driver','Test','Ward','Pathologist'])->orderBy('id', 'asc')->get();
             }          
             return view('home.doctor',['doctor'=>$doctor,'category'=>$member]);
        }

      public function doctor_details(Request $request,$id){
           $data=User::where('id',$id)->orderBy('id','asc')->first();
           return view('home.doctor-details',['data'=>$data]);
       }


        public function notice_details(Request $request, $id){
             $data=Notice::where('pagecategory_id','NewsEvent')->where('id',$id)->orderBy('serial','asc')->first();
             return view('home.notice-details',['data'=>$data]);
         }


        public function page_view(Request $request,$id){
              $data=Notice::where('pagecategory_id',$id)->orderBy('id','asc')->first();
              return view('home.page-view',['data'=>$data]);
         }

        public function service_form(Request $request,$id){
            $data=Notice::where('pagecategory_id',$id)->orderBy('id','asc')->get();
            return view('home.service-form',['data'=>$data]);
         }

         public function service_schedule(Request $request,$service_name){

             $chamber = Chamber::leftJoin('users', 'users.id', '=', 'chambers.user_id')
              ->where('service_name',$service_name)
              ->select('users.name', 'chambers.*' )->get();

             return view('home.service-schedule',['chamber'=>$chamber , 'service_name'=>$service_name]);
         }


        public function staff_schedule(Request $request){
              $data = User::whereIn('userType', ['Nursing','Pharmacy','Staff'
              ,'Driver','Ward'])->select('userType')->groupBy('userType')->orderBy('id', 'asc')->get();
              return view('home.staff-schedule',['data'=>$data]);
         }
    
   }
