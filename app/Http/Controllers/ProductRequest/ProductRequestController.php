<?php
namespace App\Http\Controllers\ProductRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Generic;
use App\Models\Productrequest;
use App\Models\User;
use App\Models\Substore;
use App\Models\Stock;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductRequestController extends Controller
    {

     public function product_request(Request $request){

      
        if ($request->ajax()) {
            $data = Productrequest::latest()->get();
               return Datatables::of($data)
               ->addIndexColumn()
               ->addColumn('cmo_status', function($row){
                       $statusBtn = '';
                       switch ($row->cmo_status) {
                           case '1':
                               $statusBtn = '<button class="btn btn-success btn-sm">Verfied</button>';
                               break;
                           default:
                               $statusBtn = '<button class="btn btn-secondary btn-sm">Pending</button>';
                               break;
                       }

                    return $statusBtn;
                })
                ->addColumn('view', function($row){
                    $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="view btn btn-primary btn-sm">View</a>';
                    return $btn;
                })
                 ->addColumn('edit', function($row){
                    $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    return $btn;
                 })
                  ->addColumn('delete', function($row){
                     $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
                     return $btn;
                 })               
              ->rawColumns(['cmo_status','edit','delete','view'])
              ->make(true);
           }

          return view('productrequest.productrequest');  
       }




       public function product_request_setup(Request $request){

            $result['generic'] =Stock::with("generic")->groupBy('generic_id')
            ->select('generic_id',DB::raw("SUM(available_piece) as available_piece"))->latest()->get();
             return view('productrequest.productrequest_setup',$result); 
       }



       public function product_request_setup_update(Request $request){

        DB::beginTransaction();
        try {
            $auth=Auth::user();
            $user_type=$auth->userType;

            $date= date("Y-m-d");
            $year= date("Y");
            $month= date("m");
            $day= date("d");

            $model= new Productrequest; 
            $model->request_by = $auth->id ;
            $model->request_from = $user_type;
            $model->date=$date;
            $model->year=$year;
            $model->month=$month;
            $model->day=$day;
            $model->save();
 
            $avialble=Stock::where('generic_id',5)->get();
             
            //medicine in Pharmacy
            $generic_id = $request->post('generic_id');
            $total_piece = $request->post('total_piece');

        foreach ($generic_id as $key => $val) {  
             // \Log::info("Generic Id : ".$generic_id[$key]);
            if ($generic_id[$key]) {              
                 $available=Stock::where('generic_id',$generic_id[$key])->where('available_piece','>',0)->orderBy('id',"ASC")->get();       
                 if($available->sum('available_piece') >= $total_piece[$key]){
                     foreach($available as $row){
                         if($total_piece[$key]>0) {
                             if($row->available_piece >= $total_piece[$key]){
                                 $substore = new Substore;
                                 $substore->request_from = $model->request_from;
                                 $substore->productrequest_id  = $model->id;
                                 $substore->generic_id  = $row->generic_id;
                                 $substore->stock_id  = $row->id;
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



       public function product_request_view(Request $request)
       {
              $id = $request->id;
              $data = Substore::with('generic')->with('stock')->where('productrequest_id',$id)->get();
              return response()->json([
                'status' => 200,
                'value' => $data,
              ]);
        }
 



     
   }