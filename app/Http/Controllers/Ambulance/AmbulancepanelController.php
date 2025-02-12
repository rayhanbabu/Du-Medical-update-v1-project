<?php
namespace App\Http\Controllers\Ambulance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Testprovide;
use App\Models\Ambulance;
use App\Models\Medicineprovide;
use App\Models\Member;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AmbulancepanelController extends Controller
{
     public function ambulance(Request $request){

        $member=Member::where('member_status',1)->get();
        $driver=User::where('userType','Driver')->where('status',1)->get();
        if ($request->ajax()) {
            $data = Ambulance::leftjoin('members','members.id','=','ambulances.member_id')
              ->leftjoin('users','users.id','=','ambulances.driver_id')
               ->select('members.member_name','members.phone','members.registration','users.name','users.phone as driver_phone','ambulances.*')->latest()->get();
               return Datatables::of($data)
               ->addIndexColumn()
               ->addColumn('status', function($row){
                     $statusBtn = '';
                     switch ($row->status) {
                           case '1':
                               $statusBtn = '<button class="btn btn-success btn-sm">Completed</button>';
                               break;
                           case '5':
                               $statusBtn = '<button class="btn btn-danger btn-sm">Canceled</button>';
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
                   ->addColumn('ref_teacher', function($row){
                      return member_name($row->ref_teacher)?member_name($row->ref_teacher)['member_name']:"";
                  })
                 ->rawColumns(['ref_teacher','status','edit','delete'])
                 ->make(true);
           }
          return view('ambulance.ambulance',['member'=>$member,'driver'=>$driver]);  
       }



       public function ambulance_insert(Request $request){
     
         $user=Auth::user();
         $validator=\Validator::make($request->all(),[
             'member_id'=>'required',
             'driver_id'=>'required',
             'to_address'=>'required',
          ]);

          if($validator->fails()){
              return response()->json([
                 'status'=>400,
                 'message'=>$validator->messages(),
                ]);
         }else{     
               $date= date("Y-m-d");
               $year= date("Y");
               $month= date("m");
               $day= date("d");

              $model= new Ambulance;
              $model->driver_id = $request->input('driver_id');
              $model->member_id = $request->input('member_id');
              $model->to_address = $request->input('to_address');
              $model->ref_teacher = $request->input('ref_teacher');
              $model->disease = $request->input('disease');
              $model->created_by=$user->id;
              $model->date = $date;
              $model->year = $year;
              $model->month = $month;
              $model->day = $day;
              $model->save();
            
              return response()->json([
                'status'=>200,  
                'message'=>'Data Added Successfully',
              ]);

        }   
    }


    public function ambulance_edit(Request $request)
    {
        $id = $request->id;
        $data = Ambulance::find($id);
        return response()->json([
             'status' => 200,
             'value' => $data,
         ]);
    }


    public function ambulance_update(Request $request)
    {
        $user=Auth::user();
        $validator=\Validator::make($request->all(),[
            'driver_id'=>'required',
            'to_address'=>'required',
         ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ]);
        } else {
            $model = Ambulance::find($request->input('edit_id'));
            if ($model) {
                $date= date("Y-m-d");
                $year= date("Y");
                $month= date("m");
                $day= date("d");
                $model->driver_id = $request->input('driver_id');
                $model->to_address = $request->input('to_address');
                $model->disease = $request->input('disease');
                $model->distance = $request->input('distance');
                $model->status = $request->input('status');
                $model->created_by=$user->id;
                $model->date = $date;
                $model->year = $year;
                $model->month = $month;
                $model->day = $day;
                $model->updated_by=$user->id;
                $model->update();
                   return response()->json([
                      'status' => 200,
                      'message' => 'Data Updated Successfully'
                    ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Student not found',
                ]);
            }
        }

    }


    public function delete(Request $request)
    {
        $model = Ambulance::find($request->input('id'));
        $model->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Deleted Successfully',
        ]);
    }



     
   }