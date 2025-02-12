<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Medicineoutside;
use App\Models\Medicineprovide;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use App\Models\Stock;
use App\Models\Testoutside;
use App\Models\Testprovide;
use App\Models\Testreport;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    
    public function report_appointment(Request $request)
    {
        try {
            $doctor=User::where('userType','Doctor')->orderBy('name','asc')->get();
                 return view('report.appointment',['doctor'=>$doctor]);
           }catch (Exception $e) {
                return  view('errors.error', ['error' => $e]);
           }
      }


    public function doctor_appointment(Request $request)
    {
          $user_id = $request->user_id;
          $date1 = $request->date1;
          $date2 = $request->date2;

         $appointment=Appointment::leftjoin('users','users.id','=','appointments.user_id')
          ->leftjoin('members','members.id','=','appointments.member_id')
          ->where('user_id',$user_id)->wherebetween('date',[$date1,$date2])
          ->select('users.name','members.member_name','members.registration','appointments.*')->orderBy('id','asc')->get();
               
         $file='doctor-appointment';
         $data=[
               'date1' =>$date1,
               'date2'=>$date2
          ];
          $pdf = PDF::setPaper('a4','portrait')->loadView('reportdompdf.doctor-appointment', 
             ['appointment' => $appointment,'data'=>$data]);
                //return $pdf->download($file); portrait landscape 
          return  $pdf->stream($file, array('Attachment' => false));
                 
    }


    public function report_diagnostic(Request $request)
    { 
          try {
              $doctor=User::where('userType','Doctor')->orderBy('name','asc')->get();
                  return view('report.diagnostic',['doctor'=>$doctor]);
           }catch (Exception $e) {
                  return  view('errors.error', ['error' => $e]);
           }
    }


    public function report_nursing(Request $request)
    { 
          try {
              $doctor=User::where('userType','Doctor')->orderBy('name','asc')->get();
                  return view('report.nursing',['doctor'=>$doctor]);
           }catch (Exception $e) {
                  return  view('errors.error', ['error' => $e]);
           }
    }


    public function report_ambulance(Request $request)
    { 
          try {
              $doctor=User::where('userType','Doctor')->orderBy('name','asc')->get();
                  return view('report.ambulance',['doctor'=>$doctor]);
           }catch (Exception $e) {
                  return  view('errors.error', ['error' => $e]);
           }
    }


    public function report_rating(Request $request)
      { 
          try {
              $doctor=User::where('userType','Doctor')->orderBy('name','asc')->get();
                  return view('report.rating',['doctor'=>$doctor]);
           }catch (Exception $e) {
                  return  view('errors.error', ['error' => $e]);
           }
      }

      
      

        }


 
