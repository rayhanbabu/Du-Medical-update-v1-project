<?php
namespace App\Http\Controllers\Diagnostic;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Testprovide;
use App\Models\Diagnostic;
use App\Models\Testreport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use App\Models\Test;

class DiagnosticpanelController extends Controller
{
     public function test_list(Request $request){

        $auth=Auth::user();
        $valuesArray = explode(',',$auth->tests_id);   
        if ($request->ajax()) {
            
            $data = Testprovide::with('member')->with('testcategory')->with('user')->with('checked')->with('tested')->with('careof')->groupBy('testprovides.testcategory_id')
            ->groupBy('testprovides.appointment_id')
            ->select('testcategory_id','appointment_id',DB::raw("MAX(date) as date"),DB::raw("MAX(member_id) as member_id")
            ,DB::raw("MAX(user_id) as user_id") ,DB::raw("MAX(checked_by) as checked_by"),DB::raw("MAX(tested_by) as tested_by")
            ,DB::raw("MAX(tested_status) as tested_status"),DB::raw("MAX(checked_status) as checked_status"))->orderBy('testprovides.appointment_id','desc')->get();
  
        return Datatables::of($data)
              ->addIndexColumn()       
              ->addColumn('tested_status', function($row) {
                if ($row->tested_status == '1') {
                    $statusBtn = '<button class="btn btn-success btn-sm">Completed</button>';
                }  else {
                    $statusBtn = '<button class="btn btn-warning btn-sm">Pending</button>';
                }
                 return $statusBtn;
              })
              ->addColumn('checked_status', function($row) {
                if ($row->checked_status == '1') {
                    $statusBtn = '<button class="btn btn-success btn-sm">Verifed</button>';
                }  else {
                    $statusBtn = '<button class="btn btn-warning btn-sm">Pending</button>';
                }
                 return $statusBtn;
              })
             ->addColumn('tested', function($row) {
                 return $row->tested?$row->tested->name:"";
             })
             ->addColumn('checked', function($row) {
                return $row->checked?$row->checked->name:"";
             })
            ->addColumn('edit', function($row){
                $btn = '<a href="/diagnostic/test_report/'.$row->appointment_id.'/'.$row->testcategory_id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                return $btn;
            })
            ->addColumn('link', function($row) {
                if($row->checked_status == '1'){
                    $statusBtn = '<a target="_blank" href="/diagnostic/report/'.$row->appointment_id.'/'.$row->testcategory_id.'" class="btn btn-success btn-sm"> Print </a>';
                }else{
                    $statusBtn = '';
                }
                return $statusBtn;
             })
            ->rawColumns(['tested_status','checked_status','edit','tested','checked','link'])
            ->make(true);
       }
          return view('diagnostic.test');  

       }



        public function diagnostic_search(Request $request) { 
         
            $search_name = $request->search_name;
            $appointment = Appointment::where('id',$search_name)->first();
           
          if (!$appointment) {
              return response()->json([
                  'status' => 'fail',
                  'message' => "Invalid Information",
              ],200);
          } else {
              return response()->json([
                 'status' => 'success',
                 'message' => "Vail Information",
                 'appointment_id' =>$appointment->id,
              ],200);
         
          }    
          
      }
      


        public function diagnostic_setup(Request $request){

            $appointment_id = $request->query('appointment_id','');

           
            $result['appointment_id']=$appointment_id;
         if($appointment_id) {
              $result['appointment']=Appointment::with('member')->with('careof')->where('appointments.id',$appointment_id)->first();
              $testprovide = Testprovide::where('appointment_id',$appointment_id)->get();
             if ($testprovide->count()>0) {
                 $result['intestattr']= Testprovide::where('appointment_id',$appointment_id)->get();
                 $result['test'] = Test::where('test_status',1)->orderBy('id','desc')->get();
              } else {
                 $result['intestattr'][0]['test_id'] = '';
                 $result['intestattr'][0]['id'] = '';
                 $result['test'] = Test::where('test_status',1)->orderBy('id','desc')->get();
              }

            }
    
           
                 return view('diagnostic.diagnostic_setup',$result); 
           }



           public function diagnostic_setup_update(Request $request){

            $appointment_id = $request->post('appointment_id');
            $appointment=Appointment::with('member')->where('appointments.id',$appointment_id)->first();
                $date= date("Y-m-d");
                $year= date("Y");
                $month= date("m");
                $day= date("d");
                $auth=Auth::user();

                  //Test in Medical  Starting
           $intestid = $request->post('intestid');
           $test_id = $request->post('test_id');
           // Check if $test_id is not empty
           $unique_test_id =array_unique(array_filter($test_id));
           $nonNullCount = count($unique_test_id);
           if($nonNullCount>0){
                foreach ($intestid as $key => $val) {
                   if (isset($unique_test_id[$key]) && $unique_test_id[$key]) {
                      $test=Test::where('id',$unique_test_id[$key])->first();
                       $intestattr = [
                           'test_id' => $test_id[$key],
                           'testcategory_id' => $test->testcategory_id,
                           'appointment_id' => $appointment_id,
                           'member_category' => $appointment->member->member_category,
                           'user_id' => $auth->id,
                           'member_id' => $appointment->member->id,
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
         return response()->json([
              'status' => "success",
              'message' => "Appointment Update Successfully",
          ],200);

           }



          public function intest_delete(Request $request, $test_id){
            $model=Testprovide::find($test_id);
            $model->delete();
            return back()->with('success', 'Data Delete successfully.'); 
        } 




        public function test_report(Request $request){

            $auth=Auth::user();
            $valuesArray = explode(',',$auth->tests_id);
            $appointment_id = $request->appointment_id;
            $testcategory_id = $request->testcategory_id;
               
            $testprovide = Testprovide::with('member')->with('testcategory')->with('user')->with('checked')->with('tested')->with('careof')
                ->where('appointment_id',$appointment_id)->where('testcategory_id',$testcategory_id)->get();
  
                  $test_id_array=array();
                  foreach($testprovide as $row){
                      $test_id_array[]=$row->test_id;
                  }
                  $test_id_final = $test_id_array;
                    
       // if(test_id_access($valuesArray,$testprovide->test_id,$auth->userType)){ 
                  $testreport=Testreport::with('diagnostic')->with('character')->where('appointment_id',$appointment_id)->where('testcategory_id',$testcategory_id)
                   ->whereIn('test_id', $test_id_final)->orderBy('character_id','asc')->get();
      
                  if($testreport->count()>0){ 
                      $diagnostic_list=$testreport;
                      $table="testreports";
                  }else{
                       $diagnostic_list = Diagnostic::with('character')->whereIn('test_id',$test_id_final)->orderBy('character_id','asc')->get();
                       $table="diagnostics";
                    }
  
                 
  
              return view('diagnostic.test_report',['table'=>$table, 'testprovide'=>$testprovide->first(),'diagnostic_list'=>$diagnostic_list]);  
          //  }else{
          //      return "This Test Id No Access";
          //  }
         
          }
  
    

         public function test_report_update(Request $request)
         {   
             $diagnostic_id = $request->post('diagnostic_id');
             $result = $request->post('result');
             $reference_range = $request->post('reference_range');
             $character_id = $request->post('character_id');
            

             $testprovide_id = $request->post('testprovide_id');
             $test_id = $request->post('test_id');
             $appointment_id = $request->post('appointment_id');

             $tested_status = $request->post('tested_status');
             $checked_status = $request->post('checked_status');
             $testcategory_id = $request->post('testcategory_id');
             
             $user=Auth::user();

            $data=DB::table('testprovides')->where('id',$testprovide_id)->first();

              foreach($diagnostic_id as $key => $val) {
                   Testreport::updateOrCreate(['diagnostic_id'=>$diagnostic_id[$key],'testcategory_id'=>$testcategory_id,'appointment_id' => $appointment_id], ['diagnostic_id' => $diagnostic_id[$key]
                   ,'reference_range' => $reference_range[$key] ,'result' => $result[$key] ,'character_id' => $character_id[$key] ,'testprovide_id' => $testprovide_id
                   ,'test_id' => $test_id[$key] ,'testcategory_id' => $testcategory_id,'appointment_id' => $appointment_id ]);
              }
           
                DB::table('testprovides')->where('testcategory_id',$testcategory_id)->where('appointment_id',$appointment_id)
                ->update(['tested_status' => $tested_status,'checked_status' => $checked_status,'tested_by' => $user->id,'checked_by' => $user->id]);
            
              return response()->json([
                 'status' => "success",
                  'data' => $request->all(),
                 'message' => "Appointment Update Successfully",
              ],200);
         }


   }