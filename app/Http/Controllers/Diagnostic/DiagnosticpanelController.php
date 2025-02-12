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

class DiagnosticpanelController extends Controller
{
     public function test_list(Request $request){

        $auth=Auth::user();
        $valuesArray = explode(',',$auth->tests_id);

        if ($request->ajax()) {
             if($auth->userType=="Admin"){
                 $data = Testprovide::leftjoin('members','members.id','=','testprovides.member_id')
                    ->leftjoin('tests','tests.id','=','testprovides.test_id')
                    ->leftjoin('appointments','appointments.id','=','testprovides.appointment_id')
                    ->leftJoin('families','families.id','=','appointments.careof_id')
                    ->select('families.family_member_name','members.member_name','members.registration','tests.test_name','testprovides.*')->latest()->get();
            }else{
                 $data = Testprovide::leftjoin('members','members.id','=','testprovides.member_id')
                    ->whereIn('testprovides.test_id',$valuesArray) 
                    ->leftjoin('tests','tests.id','=','testprovides.test_id')
                    ->leftjoin('appointments','appointments.id','=','testprovides.appointment_id')
                    ->leftJoin('families','families.id','=','appointments.careof_id')
                    ->select('families.family_member_name','members.member_name','members.registration','tests.test_name','testprovides.*')->latest()->get();
             }
           
        return Datatables::of($data)
              ->addIndexColumn()       
              ->addColumn('status', function($row) {
               if ($row->test_status == '1') {
                   $statusBtn = '<button class="btn btn-success btn-sm">Completed</button>';
               } elseif ($row->test_status == '5') {
                   $statusBtn = '<button class="btn btn-warning btn-sm">Verify Pending</button>';
               } elseif ($row->test_status == '0') {
                   $statusBtn = '<button class="btn btn-danger btn-sm">Staff Pending</button>';
               } else {
                   $statusBtn = '<button class="btn btn-secondary btn-sm">Inactive</button>';
               }
               return $statusBtn;
           })
           ->addColumn('tested', function($row) {
               return user_name($row->tested_by)?user_name($row->tested_by)->name:"";
            })
            ->addColumn('checked', function($row) {
               return user_name($row->checked_by)?user_name($row->checked_by)->name:"";
            })
           ->addColumn('edit', function($row){
               $btn = '<a href="/diagnostic/test_report/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
               return $btn;
           })
          ->rawColumns(['status','edit','tested','checked'])
          ->make(true);
       }
          return view('diagnostic.test');  

       }


        public function test_report(Request $request,$testprovide_id)
          {

          $auth=Auth::user();
          $valuesArray = explode(',',$auth->tests_id);
             
          $testprovide=TestProvide::leftjoin('tests','tests.id','=','testprovides.test_id')
            ->leftjoin('members','members.id','=','testprovides.member_id')
            ->leftjoin('appointments','appointments.id','=','testprovides.appointment_id')
            ->leftjoin('users','users.id','=','appointments.user_id')
            ->where('testprovides.id',$testprovide_id)
            ->select('members.member_name','members.registration','members.gender','users.name'
            ,'members.dobirth','tests.id as test_id','tests.test_name','appointments.age','testprovides.*')->first();

        
      if(test_id_access($valuesArray,$testprovide->test_id,$auth->userType)){ 
               $testreport=Testreport::where('testprovide_id',$testprovide_id)
                  ->leftjoin('diagnostics','diagnostics.id','=','testreports.diagnostic_id')
                  ->select('diagnostics.diagnostic_name','testreports.*')->get();
    
             if($testreport->count()>0){ 
                   $diagnostic_list=$testreport;
                   $table="testreports";
              }else{
                   $diagnostic_list=Diagnostic::where('test_id',$testprovide->test_id)->get();
                   $table="diagnostics";
                  }


            return view('diagnostic.test_report',['table'=>$table, 'testprovide'=>$testprovide,'diagnostic_list'=>$diagnostic_list]);  
         }else{
             return "This Test Id No Access";
         }
       
        }




        public function diagnostic_setup(Request $request){



            $result['appointment'] = Appointment::leftJoin('members','members.id','=','appointments.member_id')
            ->leftJoin('users','users.id','=','appointments.user_id')
            ->leftJoin('chambers','chambers.id','=','appointments.chamber_id')
            ->leftJoin('families','families.id','=','appointments.careof_id')
            ->select('families.family_member_name','chambers.chamber_name','users.name','members.member_name','members.member_category','members.registration','appointments.*')->first();
    
    
    
             //Test In Medical
              $testprovide = Testprovide::where('appointment_id',19)->get();
             if ($testprovide->count()>0) {
                 $result['intestattr']= Testprovide::where('appointment_id',14)->get();
                 $result['test'] = Test::where('test_status',1)->orderBy('id','desc')->get();
             } else {
                 $result['intestattr'][0]['test_id'] = '';
                 $result['intestattr'][0]['id'] = '';
                 $result['test'] = Test::where('test_status',1)->orderBy('id','desc')->get();
             }
    
    
                 return view('diagnostic.diagnostic_setup',$result); 
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
             $test_status = $request->post('test_status');
             
             $user=Auth::user();


            $data=DB::table('testprovides')->where('id',$testprovide_id)->first();

              foreach($diagnostic_id as $key => $val) {
                   Testreport::updateOrCreate(['diagnostic_id'=>$diagnostic_id[$key],'testprovide_id'=>$testprovide_id], ['diagnostic_id' => $diagnostic_id[$key]
                   ,'reference_range' => $reference_range[$key] ,'result' => $result[$key] ,'character_id' => $character_id[$key] ,'testprovide_id' => $testprovide_id
                   ,'test_id' => $test_id ,'appointment_id' => $appointment_id ]);
              }

              if($user->userType=="Test"){
                 DB::table('testprovides')->where(['id' =>$testprovide_id])->update(['test_status'=>5,'tested_by'=>$user->id]);
              }else{
                 if(empty($data->tested_by)){
                     DB::table('testprovides')->where(['id' =>$testprovide_id])->update(['test_status'=>$test_status,'tested_by'=>$user->id,'checked_by'=>$user->id]);  
                 }
                 DB::table('testprovides')->where(['id' =>$testprovide_id])->update(['test_status'=>$test_status,'checked_by'=>$user->id]);  
              }
            
            
             return response()->json([
              'status' => "success",
              'data' => $request->all(),
              'message' => "Appointment Update Successfully",
            ],200);

         }


         public function appointment_test(Request $request){
             $auth=Auth::user();
             //$valuesArray = explode(',',$auth->tests_id);
    
            if ($request->ajax()) {
            
                    $data = Appointment::leftjoin('members','members.id','=','appointments.member_id')
                    ->leftJoin('families','families.id','=','appointments.careof_id')
                    ->select('families.family_member_name','members.member_name','members.registration','appointments.*')->latest()->get();
               
                  return Datatables::of($data)
                  ->addIndexColumn()       
                  ->addColumn('link', function($row) {
                    if(test_report_status($row->id)=='completed'){
                        $statusBtn = '<a href="/diagnostic/report/'.$row->id.'" class="btn btn-success btn-sm"> Print </a>';
                    }elseif(test_report_status($row->id) == 'processing'){
                        $statusBtn = '<button class="btn btn-warning btn-sm">Processing</button>';
                    }else{
                        $statusBtn = '';
                    }
                    return $statusBtn;
                 })
                ->rawColumns(['link'])
                ->make(true);
                }
                return view('diagnostic.appointment_test');  
    
           }
    



   }