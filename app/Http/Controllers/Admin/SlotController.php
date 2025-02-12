<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chamber;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Slot;
use App\Models\Week;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SlotController extends Controller
{
  public function slot(Request $request, $chamber_id) {
       $chamber = Chamber::leftJoin('users', 'users.id', '=', 'chambers.user_id')
          ->where('chambers.id', $chamber_id)
          ->select( 'users.name' , 'chambers.*' )
          ->first();

    $week = Week::orderBy('week_name', 'asc')->get();
    $week_name = $request->query('week_name', '');
    $slot_detail=Slot::where('slot_status',1)->where('chamber_id',$chamber_id)->select('week_name',DB::raw('count(id) as id_total'))
    ->orderBy('week_name','asc')->groupBy('week_name')->get();


    if ($chamber && $week_name) {
            $data = Slot::where('chamber_id', $chamber_id)
                ->where('week_name', $week_name)
                ->orderBy('serial','asc')->get();
    }else{
      $data=array();
    }
     
    return view('admin.slot', ["chamber" => $chamber, "week" => $week,
     "week_name" => $week_name,'data'=>$data,'slot_detail'=>$slot_detail]);
}

      public function slot_manage(Request $request, $chamber_id='', $week_name='', $id=''){

           if($id>0){
               $arr=Slot::where(['id'=>$id])->get();
               $result['id']=$arr['0']->id;
               $result['serial']=$arr['0']->serial;
               $result['slot_time']=$arr['0']->slot_time;
               $result['slot_type']=$arr['0']->slot_type;
               $result['duty_type']=$arr['0']->duty_type;
               $result['booking_last_time']=$arr['0']->booking_last_time;
               $result['slot_status']=$arr['0']->slot_status;

              
          } else {
               $result['id']='';
               $result['slot_time']='';
               $result['slot_type']='';
               $result['duty_type']='';
               $result['slot_status']='';
               $result['booking_last_time']='';
               $result['serial']='';
               $result['form']='';
               $result['mgf_date']='';
               $result['batch_no']='';
               $result['strength']='';
           }

            $result['chamber_id']=$chamber_id;
            $result['week_name']=$week_name;

       


            return view('admin.slot_manage',$result);  
        }

      public function slot_insert(Request $request)
      {
    
          if(!$request->input('id')){
              $request->validate([
                 'chamber_id' => 'required',
                 'week_name' => 'required',
                 'slot_time' => 'required',
                 'slot_type' => 'required',
                 'duty_type' => 'required',
                 'slot_status' => 'required',
                 'booking_last_time' => 'required',
                 'serial' => 'required',
               ]);
          }else{
              $request->validate([
                'chamber_id' => 'required',
                'week_name' => 'required',
                'slot_time' => 'required',
                'slot_type' => 'required',
                'duty_type' => 'required',
                'slot_status' => 'required',
                'booking_last_time' => 'required',
                'serial' => 'required',
              ]
            );
          }

        $user=Auth::user();
      if($request->post('id')>0){
          $model=Slot::find($request->post('id'));
          $model->updated_by=$user->id;
      }else{
           $model= new Slot; 
           $model->created_by=$user->id;
       }
         $model->chamber_id=$request->input('chamber_id');
         $model->week_name=$request->input('week_name');
         $model->slot_time=$request->input('slot_time');
         $model->slot_type=$request->input('slot_type');
         $model->duty_type=$request->input('duty_type');
         $model->booking_last_time=$request->input('booking_last_time');
         $model->slot_status=$request->input('slot_status');
         $model->serial=$request->input('serial');
         $model->save();

        
         return redirect('admin/slot/'.$request->input('chamber_id').'?week_name='.$request->input('week_name'))->with('success', 'Changes saved successfully.');

      }


      public function slot_delete(Request $request,$id){
           $model=Slot::find($id);
           $model->delete();
          return back()->with('success', 'Data deleted successfully.');

       }

}
