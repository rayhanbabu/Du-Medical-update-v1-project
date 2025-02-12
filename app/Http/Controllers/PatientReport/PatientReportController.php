<?php

namespace App\Http\Controllers\PatientReport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Diagnostic;
use App\Models\Medicineprovide;
use App\Models\Medicineoutside;
use App\Models\Testprovide;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\Testoutside;
use App\Models\Testreport;

class PatientReportController extends Controller
{
    
    public function patient_report_appointment(Request $request)
    {
        try {          
             $doctor=User::where('userType','Doctor')->orderBy('name','asc')->get();
                  return view('patientreport.appointment',['doctor'=>$doctor]);
             }catch (Exception $e) {
                  return  view('errors.error', ['error' => $e]);
            }
     }


    public function patient_report_appointment_show(Request $request)
    {
         $registration = $request->registration;
         $data=Appointment::leftJoin('members','members.id','=','appointments.member_id')
         ->where('appointment_status',1)->where('members.registration',$registration)
         ->select('members.member_name','members.registration','appointments.*')->orderBy('id','asc')->get();

        if($data->count() > 0){
              return response()->json([
                      'status'=>"success",
                      'data'=>$data,
                 ],200);
         }else{
              return response()->json([
                     'status'=> "fail",
                     'data'=> "Invalid registration number or no appointment found. ",
               ],200);
         }           
      }




      public function patient_report_diagnostic(Request $request)
      {
            try {             
                   return view('patientreport.diagnostic');
             }catch (Exception $e) {
                   return  view('errors.error', ['error' => $e]);
              }
       }
  
  
      public function patient_report_diagnostic_show(Request $request)
      {
           $registration = $request->registration;
           $data=Testprovide::leftJoin('members','members.id','=','testprovides.member_id')
           ->leftJoin('tests','tests.id','=','testprovides.test_id')
           ->where('testprovides.test_status',1)->where('members.registration',$registration)
           ->select('tests.test_name','members.member_name','members.registration','testprovides.*')->orderBy('id','asc')->get();
  
          if($data->count() > 0){
                return response()->json([
                        'status'=>"success",
                        'data'=>$data,
                   ],200);
           }else{
                return response()->json([
                       'status'=> "fail",
                       'data'=> "Invalid registration number or no diagnostic test found. ",
                 ],200);
           }           
        }


        public function patient_report_diagnostic_result(Request $request)
        {

             $testprovide_id = $request->testprovide_id;
             $data = Testreport::leftjoin('diagnostics','diagnostics.id','=','testreports.diagnostic_id')
             ->where('testprovide_id',$testprovide_id)
             ->select('diagnostics.diagnostic_name','testreports.*')->get();

            if($data->count() > 0){
                  return response()->json([
                          'status'=>"success",
                          'data'=>$data,
                     ],200);
             }else{
                  return response()->json([
                         'status'=> "fail",
                         'data'=> "Invalid registration number or no diagnostic test found. ",
                   ],200);
             }           
          }




        public function patient_report_pharmacy(Request $request)
        {
             try {             
                    return view('patientreport.pharmacy');
               }catch (Exception $e) {
                     return  view('errors.error',['error'=>$e]);
                }
         }
    
    
        public function patient_report_pharmacy_show(Request $request)
        {
             $registration = $request->registration;
             $data=Medicineprovide::leftJoin('members','members.id','=','medicineprovides.member_id')
              ->leftJoin('generics','generics.id','=','medicineprovides.generic_id')
              ->leftJoin('stocks','stocks.id','=','medicineprovides.stock_id')
              ->where('provide_status',1)->where('members.registration',$registration)
              ->select('generics.generic_name','stocks.medicine_name','members.member_name','members.registration','medicineprovides.*')->orderBy('id','asc')->get();
    
            if($data->count() > 0){
                  return response()->json([
                          'status'=>"success",
                          'data'=>$data,
                     ],200);
             }else{
                  return response()->json([
                         'status'=> "fail",
                         'data'=> "Invalid registration number or no medicine found. ",
                   ],200);
             }           
          }



          public function diagnostic_report(Request $request)
            { 
                //try {

                    $appointment_id=$request->appointment_id;
  
                    $testprovide = Testprovide::leftjoin('tests','tests.id','=','testprovides.test_id')
                    ->leftjoin('testcategories','testcategories.id','=','tests.testcategory_id')
                    ->where('testprovides.appointment_id',$appointment_id)
                    ->select('tests.testcategory_id',DB::raw("Max(testprovides.appointment_id) as appointment_id")
                    ,DB::raw("Max(testcategories.testcategory_name) as testcategory_name")
                    ,DB::raw("Max(testprovides.tested_by) as tested_by")
                    ,DB::raw("Max(testprovides.checked_by) as checked_by"))->groupBy('tests.testcategory_id')->get();
   
                    $data = Appointment::leftJoin('members','members.id','=','appointments.member_id')
                    ->leftJoin('users','users.id','=','appointments.user_id')
                    ->leftJoin('chambers','chambers.id','=','appointments.chamber_id')
                    ->leftJoin('families','families.id','=','appointments.careof_id')
                    ->where('appointments.id',$appointment_id)
                    ->select('families.family_member_name','families.relation_type','chambers.chamber_name','users.name','users.designation as user_designation'
                    ,'members.member_name','members.registration','appointments.*')->first();
  
                    $file=$data->member_name.'-'.$appointment_id.'-test report.pdf';
                    $pdf = PDF::setPaper('a4','portrait')->loadView('patientreportprint.test', 
                            ['testprovide' => $testprovide,'data'=>$data]);
          
                     return  $pdf->stream($file, array('Attachment' => false));

               //    }catch (Exception $e) {
               //           return  view('errors.error', ['error' => $e]);
               //    }
             }
  
  



  
        public function prescription_show(Request $request){ 

             try {
                    $appointment_id=$request->appointment_id;
                    $data = Appointment::leftJoin('members','members.id','=','appointments.member_id')
                      ->leftJoin('users','users.id','=','appointments.user_id')
                      ->leftJoin('chambers','chambers.id','=','appointments.chamber_id')
                      ->leftJoin('families','families.id','=','appointments.careof_id')
                      ->where('appointments.id',$appointment_id)
                      ->select('families.family_member_name','families.relation_type','chambers.chamber_name','users.name','users.designation as user_designation'
                      ,'members.member_name','members.registration','appointments.*')->first();
                   
            if(empty($data)){
                     return "Invalid Prescription Id";
             }else{
                    $medicine_provide = Medicineprovide::leftjoin('generics','generics.id','=','medicineprovides.generic_id')
                     ->leftjoin('stocks','stocks.id','=','medicineprovides.stock_id')
                     ->where('appointment_id',$appointment_id)
                     ->select('generics.generic_name','stocks.medicine_name','medicineprovides.*')->get();
     
              $medicine_out = Medicineoutside::where('appointment_id',$appointment_id)->get();
     
              $testprovide = Testprovide::leftjoin('tests','tests.id','=','testprovides.test_id')
                 ->where('appointment_id',$appointment_id)->select('tests.test_name','testprovides.*')->get();
     
              $test_out = Testoutside::where('appointment_id',$appointment_id)->get();     
     
              $file=$data->member_name.'-'.$appointment_id.'-test report.pdf';

              $pdf = PDF::setPaper('a4','portrait')->loadView('patientreportprint.prescription', 
                    ['data'=>$data,'medicine_provide'=>$medicine_provide,'medicine_out'=>$medicine_out,
                     'testprovide'=>$testprovide,'test_out'=>$test_out]);
                               //return $pdf->download($file); portrait landscape 
                   return  $pdf->stream($file, array('Attachment' => false));

               }

                  }catch (Exception $e) {
     
                       return  view('errors.error', ['error' => $e]);
                  }
             }
     
     

    


  
}
