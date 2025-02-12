<?php

namespace App\Http\Controllers\MemberPanel;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use Exception;

class MyAppointmentController extends Controller
{

    public function my_appointment(Request $request)
     {
          try { 
                  $member_id = $request->header('member_id');
                  $appointment=Appointment::where('member_id', $member_id)->orderBy('id','desc')->get();
                  return view('member.my_appointment',['appointment'=>$appointment]);
           } catch(Exception $e) {
                  return  view('errors.error',['error' => $e]);
           }
      }

     public function appointment_feedback(Request $request){
          
           return view('member.feedback');

       }



         public function appointment_slip(Request $request){
          
                 return view('member.appointment_slip');

          }


   

 }
