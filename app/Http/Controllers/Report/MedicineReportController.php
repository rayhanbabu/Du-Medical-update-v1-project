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
use Illuminate\Support\Facades\DB;

class MedicineReportController extends Controller
{

       public function report_medicine(Request $request)
       { 
            try {
                    $doctor=User::where('userType','Doctor')->orderBy('name','asc')->get();
                    return view('report.medicine',['doctor'=>$doctor]);
              }catch (Exception $e) {
                    return  view('errors.error', ['error' => $e]);
              }
       }
  
       public function report_medicine_available(Request $request) { 
  
           if($request->ajax()) {
               $data = Stock::where('stock_status',1)
               ->select('generic_id',DB::raw('count(stocks.id) as id_total')
              ,DB::raw('sum(total_piece) as total_piece'),DB::raw('sum(available_piece) as available_piece'))->orderBy('stocks.generic_id','asc')->groupBy('stocks.generic_id')->latest()->get();
                
                return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('generic_name', function($row){
                       $statusBtn =generic_name($row->generic_id); 
                       return $statusBtn;
                     })
                     ->addColumn('status', function($row){
                      $statusBtn = $row->available_piece >= 100 ? 
                          '' : 
                          '<button class="btn btn-warning btn-sm" > Warning </button>';
                       return $statusBtn;
                    })
                     ->rawColumns(['generic_name','status'])
                    ->make(true);
            }
          return view('report.medicine_available');  
         }
  
  


      
       public function datewise_provide(Request $request)
       {
             
             $date1 = $request->date1;
             $date2 = $request->date2;
   
             $medicineprovide=Medicineprovide::leftjoin('members','members.id','=','medicineprovides.member_id')
             ->leftJoin('generics','generics.id','=','medicineprovides.generic_id')
              ->leftJoin('stocks','stocks.id','=','medicineprovides.stock_id')
             ->where('provide_status',1)->wherebetween('medicineprovides.date',[$date1,$date2])
             ->select('generics.generic_name','stocks.medicine_name','members.member_name','members.registration','medicineprovides.*')->orderBy('id','asc')->get();
                  
            $file=$date1.'to'.$date2.'Medicine Provide.pdf';
            $data=[
                  'date1' =>$date1,
                  'date2'=>$date2
             ];
             $pdf = PDF::setPaper('a4','portrait')->loadView('reportprint.medicine.datewise_provide', 
                ['medicineprovide' => $medicineprovide,'data'=>$data]);
             return  $pdf->stream($file, array('Attachment' => false));
                    
       }
   


      

        }


 
