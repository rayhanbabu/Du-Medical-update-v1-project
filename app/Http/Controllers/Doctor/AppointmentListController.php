<?php

namespace App\Http\Controllers\Doctor;

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
use App\Models\Generic;
use App\Models\Medicine;
use App\Models\Medicineprovide;
use App\Models\Medicineoutside;
use App\Models\Test;
use App\Models\Testoutside;
use App\Models\Testprovide;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentListController extends Controller
{

    public function appointment_list(Request $request){

        $auth=Auth::user();

        if($request->ajax()) {
          
             $data=Appointment::with('member')->with('user')->with('created_by')->with('careof')->latest()->get();
           
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status',function($row){
                      $statusBtn = $row->appointment_status == '1' ? 
                         '<button class="btn btn-success btn-sm"> Completed </button>': 
                         '<button class="btn btn-secondary btn-sm"> Pending </button>';
                      return $statusBtn;
                 })
                 ->addColumn('prescription', function($row){
                    $btn = '<a href="/prescription/'.$row->id.'" class="btn btn-primary btn-sm">Print</a>';
                    return $btn;
                 })
                 ->addColumn('edit', function($row){
                    $btn = '<a href="/doctor/appointment/setup/'.$row->id.'" class="btn btn-primary btn-sm">Edit</a>';
                    return $btn;
                 })
                 ->addColumn('delete', function($row){
                    $btn = $row->appintment_status == '0' ? 
                     '<a href="/admin/appointment/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>' : 
                     '<button class="btn btn-secondary btn-sm"> </button>';
                     return $btn;
                  })
               ->rawColumns(['status','prescription','edit','delete'])
               ->make(true);
            }
          return view('doctor.appointment_list');  
      }


    public function appointment_setup(Request $request, $appointment_id){

        $result['appointment'] = Appointment::leftJoin('members','members.id','=','appointments.member_id')
        ->leftJoin('users','users.id','=','appointments.user_id')
        ->leftJoin('chambers','chambers.id','=','appointments.chamber_id')
        ->leftJoin('families','families.id','=','appointments.careof_id')
        ->where('appointments.id',$appointment_id)
        ->select('families.family_member_name','chambers.chamber_name','users.name','members.member_name','members.member_category','members.registration','appointments.*')->first();


        //Medicine In Pharmacy
        $data = Medicineprovide::where('appointment_id',$appointment_id)->get();
           if ($data->count()>0) {
               $result['inmedicineattr']= Medicineprovide::where('appointment_id',$appointment_id)->get();
               $result['generic'] = Generic::where('generic_status',1)->orderBy('generic_name','asc')->get();
           } else {
               $result['inmedicineattr'][0]['total_piece'] = '';
               $result['inmedicineattr'][0]['eating_time'] = '';
               $result['inmedicineattr'][0]['eating_status'] = '';
               $result['inmedicineattr'][0]['generic_id'] = '';
               $result['inmedicineattr'][0]['id'] = '';
               $result['generic'] = Generic::where('generic_status',1)->orderBy('generic_name','asc')->get();
           }


           //Medicine out of Pharmacy
           $outmedicine = Medicineoutside::where('appointment_id',$appointment_id)->get();
           if ($outmedicine->count()>0) {
               $result['outmedicineattr']= Medicineoutside::where('appointment_id',$appointment_id)->get();
           } else {
               $result['outmedicineattr'][0]['total_day'] = '';
               $result['outmedicineattr'][0]['eating_time'] = '';
               $result['outmedicineattr'][0]['eating_status'] = '';
               $result['outmedicineattr'][0]['medicine_name'] = '';
               $result['outmedicineattr'][0]['id'] = '';
           }


           //Test In Medical
        $testprovide = Testprovide::where('appointment_id',$appointment_id)->get();
         if ($testprovide->count()>0) {
             $result['intestattr']= Testprovide::where('appointment_id',$appointment_id)->get();
             $result['test'] = Test::where('test_status',1)->orderBy('id','desc')->get();
         } else {
             $result['intestattr'][0]['test_id'] = '';
             $result['intestattr'][0]['id'] = '';
             $result['test'] = Test::where('test_status',1)->orderBy('id','desc')->get();
         }

           //Test out side Medical
           $testout = Testoutside::where('appointment_id',$appointment_id)->get();
           if($testout->count()>0) {
               $result['outtestattr']= Testoutside::where('appointment_id',$appointment_id)->get();
           } else {
               $result['outtestattr'][0]['test_name'] = '';
               $result['outtestattr'][0]['id'] = '';
           }



             return view('doctor.appointment_setup',$result); 
       }



    public function appointment_setup_update(Request $request){
        
             DB::beginTransaction();
             try {
            $appointment_id = $request->post('appointment_id');
            $member_id = $request->post('member_id');
            $member_category = $request->post('member_category');
            $date= date("Y-m-d");
            $year= date("Y");
            $month= date("m");
            $day= date("d");
            $auth=Auth::user();

            $indoor_service = $request->post('indoor_service');
            $indoor_comment = $request->post('indoor_comment');
            $nursing_service = $request->post('nursing_service');
            $nursing_comment = $request->post('nursing_comment');
            $advise = $request->post('advise');

            $model = Appointment::find($appointment_id);
            if ($model) {
               if($nursing_service){
                 $model->nursing_service =$nursing_service;
                 $model->nursing_comment =$nursing_comment;
                 $model->nursing_status =0;
               }else{
                $model->nursing_service ='';
                $model->nursing_comment ='';
                $model->nursing_status ='';
               }
                if($indoor_service){
                    $model->indoor_service = $indoor_service;
                    $model->indoor_comment =  $indoor_comment;
                    $model->indoor_status =0;
                }else{
                    $model->indoor_service = '';
                    $model->indoor_comment =  '';
                    $model->indoor_status ='';
                }

                $model->advise =$advise;
                $model->user_id =$auth->id;
                $model->appointment_status=1;
                $model->update();
            }

            //medicine in Pharmacy
            $inmedicineid = $request->post('inmedicineid');
            $generic_id = $request->post('generic_id');
            $eating_time = $request->post('eating_time');
            $eating_status = $request->post('eating_status');
            $total_piece = $request->post('total_piece');

            foreach ($inmedicineid as $key => $val) {  
              if ($generic_id[$key] && $total_piece[$key] ) {          
                    $inmedicineattr['generic_id'] = $generic_id[$key];
                    $inmedicineattr['total_piece'] = $total_piece[$key];
                    $inmedicineattr['eating_time'] = $eating_time[$key];
                    $inmedicineattr['eating_status'] = $eating_status[$key];
                    $inmedicineattr['appointment_id'] = $appointment_id;
                    $inmedicineattr['member_category'] = $member_category;
                    $inmedicineattr['user_id'] = $auth->id;
                    $inmedicineattr['member_id'] = $member_id;
                    $inmedicineattr['date'] = $date;
                    $inmedicineattr['month'] = $month;
                    $inmedicineattr['year'] = $year;
                    $inmedicineattr['day'] = $day;
   
                   if ($inmedicineid[$key] != '') {
                        DB::table('medicineprovides')->where(['id' => $inmedicineid[$key]])->where('provide_status',0)->update($inmedicineattr);
                    } else {
                        DB::table('medicineprovides')->insert($inmedicineattr);
                    }    
                }
          }

          //Medicine Out of Pharmacy
           $outmedicineid = $request->post('outmedicineid');
           $medicine_name = $request->post('medicine_name');
           $outeating_time = $request->post('outeating_time');
           $outeating_status = $request->post('outeating_status');
           $total_day = $request->post('total_day');

           foreach ($outmedicineid as $key => $val) {  
            if ($medicine_name[$key] && $total_day[$key] ) {          
                  $outmedicineattr['medicine_name'] = $medicine_name[$key];
                  $outmedicineattr['total_day'] = $total_day[$key];
                  $outmedicineattr['eating_time'] = $outeating_time[$key];
                  $outmedicineattr['eating_status'] = $outeating_status[$key];
                  $outmedicineattr['appointment_id'] = $appointment_id;
                  $outmedicineattr['member_category'] = $member_category;
                  $outmedicineattr['user_id'] = $auth->id;
                  $outmedicineattr['member_id'] = $member_id;
                  $outmedicineattr['date'] = $date;
                  $outmedicineattr['month'] = $month;
                  $outmedicineattr['year'] = $year;
                  $outmedicineattr['day'] = $day;
        
                 if ($outmedicineid[$key] != '') {
                      DB::table('medicineoutsides')->where(['id' => $outmedicineid[$key]])->update($outmedicineattr);
                  } else {
                      DB::table('medicineoutsides')->insert($outmedicineattr);
                  }    
              }
           }


          //Test in Medical  Starting
           $intestid = $request->post('intestid');
           $test_id = $request->post('test_id');
           // Check if $test_id is not empty
           $nonNullCount = count(array_filter($test_id));
           if($nonNullCount>0){
                foreach ($intestid as $key => $val) {
                   if (isset($test_id[$key]) && $test_id[$key]) {
                      $test=Test::where('id',$test_id[$key])->first();
                       $intestattr = [
                           'test_id' => $test_id[$key],
                           'test_id' => $test_id[$key],
                           'appointment_id' => $appointment_id,
                           'member_category' => $member_category,
                           'user_id' => $auth->id,
                           'member_id' => $member_id,
                           'date' => $date,
                           'month' => $month,
                           'year' => $year,
                           'day' => $day,
                       ];
           
                       if (!empty($intestid[$key])) {
                           // Update existing record
                           DB::table('testprovides')->where('id',$intestid[$key])->where('test_status',0)->update($intestattr);
                       } else {
                           // Insert new record
                           DB::table('testprovides')->insert($intestattr);
                       }
                   }
               }
            }else{
                Testprovide::where('appointment_id', $appointment_id)->delete();
            }
         //Test in Medical  Ending   


         //Test in Medical  Starting
         $outtestid = $request->post('outtestid');
         $test_name = $request->post('test_name');
         // Check if $test_id is not empty
         $nonNullCount = count(array_filter($test_name));
         if($nonNullCount>0){
              foreach ($outtestid as $key => $val) {
                 if (isset($test_name[$key]) && $test_name[$key]) {
                     $outtestattr = [
                         'test_name' => $test_name[$key],
                         'appointment_id' => $appointment_id,
                         'member_category' => $member_category,
                         'user_id' => $auth->id,
                         'member_id' => $member_id,
                         'date' => $date,
                         'month' => $month,
                         'year' => $year,
                         'day' => $day,
                     ];
         
                     if (!empty($outtestid[$key])) {
                         // Update existing record
                         DB::table('testoutsides')->where('id', $outtestid[$key])->update($outtestattr);
                     } else {
                         // Insert new record
                         DB::table('testoutsides')->insert($outtestattr);
                     }
                 }
             }
          }else{
              Testoutside::where('appointment_id', $appointment_id)->delete();
          }
       //Test in Medical  Ending   
 
         
           DB::commit();    
            return response()->json([
                  'status' => "success",
                  'message' => "Appointment Update Successfully",
             ],200);

         } catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                  'status' => 'fail',
                'message' => 'Some error occurred. Please try again',
              ],200);
         }
  
           
 


        }


        public function inmedicine_delete(Request $request,$medicine_id){
             $medicine_id=$medicine_id;
             $model=Medicineprovide::find($medicine_id);
             if($model->provide_status==1){
                  return back()->with('fail', 'Medicine Already Provided .');
              }else{
                  $model->delete();
                  return back()->with('success', 'DAta Delete successfully.');
             }
         } 


         public function outmedicine_delete(Request $request,$outmedicine_id){
             $outmedicine_id=$outmedicine_id;
             $model=Medicineoutside::find($outmedicine_id);
             $model->delete();
             return back()->with('success', 'Data Delete successfully.'); 
        } 


         public function intest_delete(Request $request, $intest_id){
              $intest_id=$intest_id;
              $model=Testprovide::find($intest_id);
              $model->delete();
              return back()->with('success', 'Data Delete successfully.'); 
          } 

          public function outtest_delete(Request $request, $outtest_id){
              $outtest_id=$outtest_id;
              $model=Testoutside::find($outtest_id);
              $model->delete();
              return back()->with('success', 'Data Delete successfully.'); 
          } 





     
   }
