<?php
namespace App\Http\Controllers\Oncall;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Member;
use App\Models\Oncall;
use App\Models\User;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OncallpanelController extends Controller
    {
     public function oncall(Request $request){

        $member=Member::where('member_status',1)->get();
        $doctor=User::where('userType','Doctor')->where('status',1)->get();
        if ($request->ajax()) {
            $data = Oncall::leftjoin('members','members.id','=','oncalls.member_id')
              ->leftjoin('users','users.id','=','oncalls.doctor_id')
               ->select('members.member_name','members.phone','members.registration','users.name','users.phone as driver_phone','oncalls.*')->latest()->get();
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

          return view('oncall.oncall',['member'=>$member,'doctor'=>$doctor]);  
       }



       public function oncall_insert(Request $request){
     
         $user=Auth::user();
         $validator=\Validator::make($request->all(),[
             'member_id'=>'required',
             'disease'=>'required',
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

              $model= new Oncall;
              $model->member_id = $request->input('member_id');
              $model->disease = $request->input('disease');
              $model->address = $request->input('address');
              $model->doctor_id = $request->input('doctor_id');
              $model->ref_teacher = $request->input('ref_teacher');
              $model->user_id=$user->id;
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


    public function oncall_edit(Request $request)
    {
        $id = $request->id;
        $data = Oncall::find($id);
        return response()->json([
             'status' => 200,
             'value' => $data,
         ]);
    }


    public function oncall_update(Request $request)
    {
         $user=Auth::user();
         $validator=\Validator::make($request->all(),[
              'disease'=>'required',
         ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validator->messages(),
            ]);
        } else {
            $model = Oncall::find($request->input('edit_id'));
            if($model){
                $date= date("Y-m-d");
                $year= date("Y");
                $month= date("m");
                $day= date("d");
                $model->disease = $request->input('disease');
                $model->comment = $request->input('comment');
                $model->status = $request->input('status');
                $model->address = $request->input('address');
                $model->user_id=$user->id;
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
        $model = Oncall::find($request->input('id'));
        $model->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Data Deleted Successfully',
        ]);
    }



     
   }