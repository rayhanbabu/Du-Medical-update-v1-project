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

         if($request->ajax()) {
               $data = Productrequest::with('provide')->with('request')->latest()->get();
               return Datatables::of($data)
                ->addIndexColumn()
                  ->addColumn('cmo_status', function($row){
                       $statusBtn = '';
                       switch ($row->cmo_status) {
                           case '1':
                              $statusBtn = '<a href="/admin/product_request/cmo_status/'.$row->id.'/0" onclick="return confirm(\'Are you sure you want to Change Status?\')" class="btn btn-success btn-sm"> Approved </a>';
                                break;
                           default:
                              $statusBtn = '<a href="/admin/product_request/cmo_status/'.$row->id.'/1" onclick="return confirm(\'Are you sure you want to Change Status?\')" class="btn btn-danger btn-sm"> Pending </a>';
                               break;
                       }
                    return $statusBtn;
                })
                ->addColumn('provide_status', function($row){
                    $statusBtn = '';
                    switch ($row->provide_status) {
                        case '1':
                           $statusBtn = '<a href="/admin/product_request/provide_status/'.$row->id.'/0" onclick="return confirm(\'Are you sure you want to Change Status?\')" class="btn btn-success btn-sm"> Approved </a>';
                             break;
                        default:
                           $statusBtn = '<a href="/admin/product_request/provide_status/'.$row->id.'/1" onclick="return confirm(\'Are you sure you want to Change Status?\')" class="btn btn-danger btn-sm"> Pending </a>';
                            break;
                    }
                 return $statusBtn;
                })
                 ->addColumn('provide', function($row) {
                     return $row->provide?$row->provide->name:"";
                 })
                 ->addColumn('request', function($row) {
                    return $row->request?$row->request->name:"";
                })
                  ->addColumn('view', function($row){
                    $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="view btn btn-primary btn-sm">View</a>';
                    return $btn;
                  })
                
                  ->addColumn('delete', function($row){
                     $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
                     return $btn;
                 })   
                 ->addColumn('print', function($row) {
                      return '<a href="/admin/product_request/print/'.$row->id.'"  class="btn btn-success btn-sm"> Print </a>';
                })            
               ->rawColumns(['cmo_status','provide_status','delete','view','provide','request','print'])
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



       public function product_request_cmo_status(Request $request)
       {
          DB::beginTransaction();
          try {
                $id = $request->id;
                $status = $request->status;

                Productrequest::where('id',$id)->update(['cmo_status'=>$status]);
                Substore::where('productrequest_id',$id)->update(['cmo_status'=>$status]);

                DB::commit();
                return back()->with('success', 'Changes saved successfully.');

            } catch (\Exception $e) {
                DB::rollback();
                return back()->with('fail', 'Error occurred while saving changes.');
            }
  
        }
 

        public function product_request_provide_status(Request $request)
        {

              DB::beginTransaction();
              try {
                 $auth=Auth::user();
                 $id = $request->id;
                 $status = $request->status;

                 Productrequest::where('id',$id)->update(['provide_status'=>$status,'provide_by'=>$auth->id]);
                 Substore::where('productrequest_id',$id)->update(['provide_status'=>$status]);
 
                 DB::commit();
                 return back()->with('success', 'Changes saved successfully.');
 
             } catch (\Exception $e) {
                  DB::rollback();
                  return back()->with('fail', 'Error occurred while saving changes.');
             }
   
         }
  


       public function product_request_view(Request $request){
              $id = $request->id;
              $data = Substore::with('generic')->with('stock')->where('productrequest_id',$id)->get();
                 return response()->json([
                    'status' => 200,
                    'value' => $data,
                 ]);
        }



        public function delete(Request $request) {

            DB::beginTransaction();
            try {
            $model = Productrequest::find($request->input('id'));
            if (!$model) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Product request not found',
                ]);
            }
        
            if ($model->cmo_status == 0 && $model->provide_status == 0) {
                $substoreItems = Substore::where('productrequest_id', $request->input('id'))->get();
        
                foreach ($substoreItems as $row) {
                    $stock = Stock::find($row->stock_id);
                    if ($stock) {
                        $stock->available_piece += $row->total_unit;
                        $stock->save();
                    }
                }
        
                // Delete all related substore records
                Substore::where('productrequest_id', $request->input('id'))->delete();
                
                // Delete the main model
                $model->delete();
                
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'message' => 'Data Deleted Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Product cannot be deleted',
                ]);
            }
        

        } catch (\Exception $e) {
              DB::rollback();
             return back()->with('fail', 'Error occurred while saving changes.');
        }  

      }
     



   }