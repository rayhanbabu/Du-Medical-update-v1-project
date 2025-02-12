<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{

      public function index(Request $request){
            return view('admin.dashboard');  
        }


        public function role_access(Request $request){
           if ($request->ajax()) {
                $data = User::latest()->where('userType', '!=', 'Admin')->get();
                return Datatables::of($data)
                   ->addIndexColumn()
                   ->addColumn('image', function($row){
                    $imageUrl = asset('uploads/admin/'.$row->image); // Assuming 'image' is the field name in the database
                    return '<img src="'.$imageUrl.'" alt="Image" style="width: 50px; height: 50px;"/>';
                  })
                  ->addColumn('status', function($row){
                    $statusBtn = $row->status == '1' ? 
                        '<button class="btn btn-success btn-sm">Active</button>' : 
                        '<button class="btn btn-secondary btn-sm" >Inactive</button>';
                    return $statusBtn;
                  })
                   ->addColumn('edit', function($row){
                      $btn = '<a href="/admin/role_access/manage/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                      return $btn;
                  })
                  ->addColumn('delete', function($row){
                    $btn = '<a href="/admin/role_access/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $btn;
                })
                  ->rawColumns(['image','status','edit','delete'])
                  ->make(true);
               }
             return view('admin.role_access');  
         }


         public function role_access_manage(Request $request, $id=''){

           $result['test']=DB::table('tests')->where('test_status',1)->orderBy('test_name','asc')->get();
           
           if($id>0){
                $arr=User::where(['id'=>$id])->get();
                $result['id']=$arr['0']->id;
                $result['name']=$arr['0']->name;
                $result['phone']=$arr['0']->phone;
                $result['userType']=$arr['0']->userType;
                $result['email']=$arr['0']->email;
                $result['designation']=$arr['0']->designation;
                $result['status']=$arr['0']->status;
                $result['oncall_access']=$arr['0']->oncall_access;
                $result['offline_reg_access']=$arr['0']->offline_reg_access;
                $result['reports_access']=$arr['0']->reports_access;
                $result['patient_report_access']=$arr['0']->patient_report_access;
                $result['degree']=$arr['0']->degree;
                $result['department']=$arr['0']->department;
                $result['doctor_type']=$arr['0']->doctor_type;

  	
               $result['tests'] = explode(',', $arr['0']->tests_id);

            } else {
                $result['id']='';
                $result['name']='';
                $result['phone']='';
                $result['email']='';
                $result['designation']='';
                $result['userType']='';
                $result['status']='';
                $result['offline_reg_access']='';
                $result['reports_access']='';
                $result['patient_report_access']='';
                $result['oncall_access']='';
                $result['tests']=[];
                $result['degree']='';
                $result['department']='';
                $result['doctor_type']='';


              }

               return view('admin.role_access_manage',$result);  
           }


         public function role_access_insert(Request $request)
         {
       
             if(!$request->input('id')){
                $request->validate([
                    'name' => ['required', 'string', 'max:255'],
                    'designation' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                    'image' =>'image|mimes:jpeg,png,jpg|max:500',
                    'phone' => 'required|unique:users,phone',
                ]);
             }else{
                $request->validate([
                   'name' => ['required', 'string', 'max:255'],
                   'designation' => ['required', 'string', 'max:255'],
                   'email'=>'required|unique:users,email,'.$request->post('id'),
                   'phone'=>'required|unique:users,phone,'.$request->post('id'),
                   'image' =>'image|mimes:jpeg,png,jpg|max:500',
                ]);
             }

         if($request->post('id')>0){
             $model=User::find($request->post('id'));
             $model->status=$request->input('status');
              if($request->hasfile('image')){
                 $path=public_path('uploads/admin/').$model->image;
                 if(File::exists($path)){
                   File::delete($path);
                  }
 
                $image= $request->file('image');
                $file_name = 'image'.rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/admin'), $file_name);
                $model->image=$file_name;
               }

               if(!empty($request->input('tests_id'))){
                   $tests_id='';
                  foreach($request->input('tests_id') as $value) {
                          $tests_id.= $value.",";
                    }
                  $model->tests_id=$tests_id;   
               }else{
                   $model->tests_id='';   
               }
              
   
         }else{
              $model= new User;
              $model->password=Hash::make($request->password);
              if($request->hasfile('image')){
                $image= $request->file('image');
                $file_name = 'image'.rand() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/admin'), $file_name);
                $model->image=$file_name;
              }
          }
          
            $model->name=$request->input('name');
            $model->designation=$request->input('designation');
            $model->phone=$request->input('phone');
            $model->userType=$request->input('userType');
            $model->email=$request->input('email');
            $model->offline_reg_access=$request->input('offline_reg_access');
            $model->reports_access=$request->input('reports_access');
            $model->oncall_access=$request->input('oncall_access');
            $model->patient_report_access=$request->input('patient_report_access');
            $model->degree=$request->input('degree');
            $model->department=$request->input('department');
            $model->doctor_type=$request->input('doctor_type');
            $model->save();


            return redirect('/admin/role_access')->with('success', 'Changes saved successfully.');

         }


         public function role_access_delete(Request $request,$id){
               
            $model=User::find($id);
            $filePath = public_path('uploads/admin') . '/' . $model->image;
             if(File::exists($filePath)){
                   File::delete($filePath);
               }
            $model->delete();
            return back()->with('success', 'Data deleted successfully.');

          }



    


}
