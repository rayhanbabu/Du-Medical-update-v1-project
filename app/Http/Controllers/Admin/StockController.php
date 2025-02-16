<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Stock;
use App\Models\Generic;
use App\Models\Brand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function stock(Request $request){
       if($request->ajax()){
          
            $data=Stock::with('create')->with("generic")->with("brand")->latest()->orderBy('stocks.id','desc')->get();
             return Datatables::of($data)
                ->addIndexColumn()
               ->addColumn('status', function($row){
                  $statusBtn = $row->stock_status == '1' ? 
                      '<button class="btn btn-success btn-sm">Active</button>' : 
                      '<button class="btn btn-secondary btn-sm" >Inactive</button>';
                   return $statusBtn;
                })
                ->addColumn('edit', function($row){
                   $btn = '<a href="/admin/stock/manage/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                   return $btn;
               })
               ->addColumn('delete', function($row){
                 $btn = '<a href="/admin/stock/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>';
                 return $btn;
             })
               ->rawColumns(['status','edit','delete'])
               ->make(true);
           }
        return view('admin.stock');  
      }


      public function stock_manage(Request $request, $id=''){

          $result['brand']=Brand::where('brand_status',1)->orderBy('brand_name','asc')->get();
          $result['generic']=Generic::where('generic_status',1)->orderBy('generic_name','asc')->get();
           if($id>0){
               $arr=Stock::where(['id'=>$id])->get();
               $result['id']=$arr['0']->id;
               $result['generic_id']=$arr['0']->generic_id;
               $result['brand_id']=$arr['0']->brand_id;
               $result['medicine_name']=$arr['0']->medicine_name;
               $result['box']=$arr['0']->box;
               $result['piece_per_box']=$arr['0']->piece_per_box;
               $result['total_amount']=$arr['0']->total_amount;
               $result['sale_per_piece']=$arr['0']->sale_per_piece;
               $result['stock_status']=$arr['0']->stock_status;
               $result['expired_date']=$arr['0']->expired_date;

               $result['form']=$arr['0']->form;
               $result['mgf_date']=$arr['0']->mgf_date;
               $result['batch_no']=$arr['0']->batch_no;
               $result['strength']=$arr['0']->strength;
               $result['cost_per_piece']=$arr['0']->cost_per_piece;
          } else {
               $result['id']='';
               $result['generic_id']='';
               $result['brand_id']='';
               $result['medicine_name']='';
               $result['box']='';
               $result['piece_per_box']='';
               $result['total_amount']='';
               $result['sale_per_piece']='';
               $result['stock_status']='';
               $result['expired_date']='';

               $result['form']='';
               $result['mgf_date']='';
               $result['batch_no']='';
               $result['strength']='';
               $result['cost_per_piece']='';
           
          }

            return view('admin.stock_manage',$result);  
        }

      public function stock_insert(Request $request)
      {
    
          if(!$request->input('id')){
              $request->validate([
                 'medicine_name' => 'required',
                 'stock_status' => 'required',
                 'generic_id' => 'required',
                 'brand_id' => 'required',
                 'box' => 'required',
                 'piece_per_box' => 'required',
                 'cost_per_piece' => 'required',
                 'expired_date' => 'required',

               ]);
          }else{
              $request->validate([
                 'medicine_name' => 'required',
                 'stock_status' => 'required',
                 'generic_id' => 'required',
                 'brand_id' => 'required',
                 'box' => 'required',
                 'piece_per_box' => 'required',
                 'total_amount' => 'required',
                 'cost_per_piece' => 'required',
                 'expired_date' => 'required',
                

              ]);
          }

        $user=Auth::user();
      if($request->post('id')>0){
          $model=Stock::find($request->post('id'));
          $model->updated_by=$user->id;
      }else{
           $model= new Stock; 
           $model->created_by=$user->id;
       }

         $date= date("Y-m-d");
         $year= date("Y");
         $month= date("m");
         $day= date("d");

          $total_peice=$request->input('piece_per_box')*$request->input('box');

          $model->user_id=$user->id;
          $model->generic_id=$request->input('generic_id');
          $model->brand_id=$request->input('brand_id');
          $model->medicine_name=$request->input('medicine_name');
          $model->box=$request->input('box');
          $model->piece_per_box=$request->input('piece_per_box');
          $model->total_amount=($request->input('cost_per_piece')*$total_peice);
          $model->cost_per_piece=$request->input('cost_per_piece');
          $model->stock_status=$request->input('stock_status');
          $model->expired_date=$request->input('expired_date');
          $model->total_piece=$total_peice;
          $model->available_piece=$total_peice;

          $model->mgf_date=$request->input('mgf_date');
          $model->batch_no=$request->input('batch_no');
          $model->strength=$request->input('strength');
          $model->date = $date;
          $model->year = $year;
          $model->month = $month;
          $model->day = $day;
          $model->save();

         return redirect('/admin/stock')->with('success', 'Changes saved successfully.');

      }


      public function stock_delete(Request $request,$id){
            
         $model=Stock::find($id);
         $model->delete();
         return back()->with('success', 'Data deleted successfully.');

       }


       public function stock_available(Request $request){
        if($request->ajax()){
           
             $data=Stock::with("generic")->groupBy('generic_id')
             ->select('generic_id',DB::raw("SUM(available_piece) as available_piece"),
             DB::raw("SUM(available_piece) as available_piece"))->latest()->get();
              return Datatables::of($data)
                 ->addIndexColumn()
                ->addColumn('status', function($row){
                   $statusBtn = $row->available_piece > $row->generic->warning_value ? 
                       '' : 
                       '<button class="btn btn-danger btn-sm">Warning</button>';
                    return $statusBtn;
                 })
                ->rawColumns(['status'])
                ->make(true);
            }
         return view('admin.stock_available');  
       }
 

}
