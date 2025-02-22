<?php
namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Testprovide;
use App\Models\Diagnostic;
use App\Models\Medicineprovide;
use App\Models\Stock;
use App\Models\Substore;
use App\Models\Testreport;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class PharmacypanelController extends Controller
{
     public function medicine_list(Request $request){
        if($request->ajax()) {

           $data = Medicineprovide::with('member')->with('appointment')->with('careof')->with('create')->groupBy('medicineprovides.appointment_id')
              ->select('appointment_id',DB::raw("MAX(date) as date"),DB::raw("MAX(member_id) as member_id")
               ,DB::raw("MAX(created_by) as created_by"))
               ->orderBy('medicineprovides.appointment_id','desc')->get();
            
           return Datatables::of($data)
             ->addIndexColumn()
             ->addColumn('careof', function($row) {
                   return $row->careof?$row->careof->family_member_name:"";
               })
               ->addColumn('view', function($row){
                    $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="view btn btn-primary btn-sm">View</a>';
                    return $btn;
                })
               ->addColumn('delete', function($row){
                   $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" data-provide_status="' . $row->provide_status . '" class="delete btn btn-danger btn-sm"> Delete </a>';
                   return $btn;
                })
                ->rawColumns(['delete','careof','view'])
               ->make(true);
            }

          return view('pharmacy.medicine_list');  

       }



       public function pharmacy_setup(Request $request){

         $appointment_id = $request->query('appointment_id','');

         $result['appointment_id']=$appointment_id;
      if($appointment_id) {
           $result['appointment']=Appointment::with('member')->with('careof')->where('appointments.id',$appointment_id)->first();
    
           $result['generic'] =Substore::with("generic")->groupBy('generic_id')
           ->select('generic_id',DB::raw("SUM(available_unit) as available_unit"))->latest()->get();

         }
              return view('pharmacy.pharmacy_setup',$result); 
        }



    public function pharmacy_search(Request $request) { 

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


     // pharmacy Setup Form

     public function pharmacy_setup_update(Request $request){

      DB::beginTransaction();
      try {
          $auth=Auth::user();
          $user_type=$auth->userType;

          $date= date("Y-m-d");
          $year= date("Y");
          $month= date("m");
          $day= date("d");

          $avialble=Substore::where('generic_id',5)->get();
           
          //medicine in Pharmacy
          $generic_id = $request->post('generic_id');
          $total_piece = $request->post('total_piece');
          $appointment_id = $request->post('appointment_id');



      foreach ($generic_id as $key => $val) {  
           // \Log::info("Generic Id : ".$generic_id[$key]);
          if ($generic_id[$key]) {              
               $available=Substore::where('generic_id',$generic_id[$key])->where('available_unit','>',0)->orderBy('id',"ASC")->get();       
               if($available->sum('available_unit') >= $total_piece[$key]){
                   foreach($available as $row){
                       if($total_piece[$key]>0) {
                           if($row->available_unit >= $total_piece[$key]){
                               $substore = new Medicineprovide;
                               $substore->appointment_id = $appointment_id;
                               $substore->productrequest_id  = $model->id;
                               $substore->generic_id  = $row->generic_id;
                               $substore->stock_id  = $row->stock_id;
                               $substore->total_unit = $total_piece[$key];
                               $substore->available_unit = $total_piece[$key];
                               $substore->save();
                              
                               $update_stock = Stock::where('id',$row->id)->update(['available_piece'=>$row->available_piece - $total_piece[$key]]);
                               $total_piece[$key]=0;
                          }else{
                               $substore = new Substore;
                               $substore->request_from = $model->request_from;
                               $substore->productrequest_id  = $model->id;
                               $substore->generic_id  = $row->generic_id;
                               $substore->stock_id  = $row->id;
                               $substore->total_unit = $row->available_piece;
                               $substore->available_unit = $row->available_piece;
                               $substore->save();
                              
                               $update_stock = Stock::where('id',$row->id)->update(['available_piece'=>0]);
                               $total_piece[$key] = $total_piece[$key] - $row->available_piece;
                            }
                         }
                      }
                 }
                 
               }
        }

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

   


       public function medicine_status(Request $request)
       {

         $data = Medicineprovide::find($request->input('id'));
         $generic_id=$data->generic_id;
         $stock = Stock::where('generic_id', $generic_id)
         ->where('available_piece', '>=', $data->total_piece)
         ->orderBy('id','desc')
         ->first();
         if($request->input('provide_status')==1){
              $status=0;
              $current_piece=$stock->available_piece+$data->total_piece;
         }else{
              $status=1;
              $current_piece=$stock->available_piece-$data->total_piece;
           }

             $stockmodel = Stock::find($stock->id);
             $stockmodel->available_piece =$current_piece ;
             $stockmodel->update();

             
           
              $model = Medicineprovide::find($request->input('id'));
              $model->brand_id =$stock->brand_id ;
              $model->stock_id =$stock->id ;
              $model->per_amount =$stock->sale_per_piece ;
              $model->total_amount =$stock->sale_per_piece*$data->total_piece ;
              $model->provide_status =$status ;
              $model->update();
           return response()->json([
               'status' => 200,
               'stock' => $stock,
               'message' => 'Data Updated Successfully',
           ]);
   
           // }
       }
   

     
   }