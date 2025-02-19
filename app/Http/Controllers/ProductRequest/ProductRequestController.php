<?php
namespace App\Http\Controllers\ProductRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Generic;
use App\Models\Productrequest;
use App\Models\User;
use App\Models\Substore;
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
                 ->addColumn('edit', function($row){
                    $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    return $btn;
                 })
                  ->addColumn('delete', function($row){
                     $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
                     return $btn;
                 })               
              ->rawColumns(['cmo_status','edit','delete'])
              ->make(true);
           }

          return view('productrequest.productrequest');  
       }




       public function product_request_setup(Request $request){

            $result['generic'] = Generic::where('generic_status',1)->orderBy('generic_name','asc')->get();
             return view('productrequest.productrequest_setup',$result); 
       }



       public function diagnostic_setup_update(Request $request){

        $appointment_id = $request->post('appointment_id');
        $appointment=Appointment::with('member')->where('appointments.id',$appointment_id)->first();
            $date= date("Y-m-d");
            $year= date("Y");
            $month= date("m");
            $day= date("d");
            $auth=Auth::user();

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
     //Test in Medical  Ending   
     return response()->json([
          'status' => "success",
          'message' => "Appointment Update Successfully",
      ],200);

       }





     
   }