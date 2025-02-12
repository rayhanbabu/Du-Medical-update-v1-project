<?php
namespace App\Http\Controllers\Pharmacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Testprovide;
use App\Models\Diagnostic;
use App\Models\Medicineprovide;
use App\Models\Stock;
use App\Models\Testreport;
use Illuminate\Support\Facades\DB;

class PharmacypanelController extends Controller
{
     public function medicine_list(Request $request){
        if ($request->ajax()) {
            $data = Medicineprovide::leftjoin('members','members.id','=','medicineprovides.member_id')
               ->leftjoin('generics','generics.id','=','medicineprovides.generic_id')
               ->leftjoin('stocks','stocks.id','=','medicineprovides.stock_id')
               ->leftjoin('appointments','appointments.id','=','medicineprovides.appointment_id')
               ->leftJoin('families','families.id','=','appointments.careof_id')
               ->select('families.family_member_name','members.member_name','members.registration','generics.generic_name','stocks.medicine_name','medicineprovides.*')->latest()->get();
               return Datatables::of($data)
               ->addIndexColumn()
          
            ->addColumn('status', function($row){
                $statusBtn = $row->provide_status == '1' ? 
                   '<button class="btn btn-success btn-sm">Recived</button>' : 
                   '<button class="btn btn-secondary btn-sm" >Pending</button>';
               return $statusBtn;
            })
            ->addColumn('delete', function($row){
               $btn = '<a href="javascript:void(0);" data-id="' . $row->id . '" data-provide_status="' . $row->provide_status . '" class="delete btn btn-info btn-sm"> Click Here</a>';
               return $btn;
           })
          ->rawColumns(['status','delete'])
          ->make(true);
       }

          return view('pharmacy.medicine_list');  

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