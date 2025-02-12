<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Character;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class CharacterController extends Controller
{
    public function character(Request $request){
        if ($request->ajax()) {
             $data = Character::latest()->get();
             return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                    $statusBtn = $row->character_status == '1' ? 
                        '<button class="btn btn-success btn-sm">Active</button>' : 
                        '<button class="btn btn-secondary btn-sm">Inactive</button>';
                     return $statusBtn;
                 })
                 ->addColumn('edit', function($row){
                   $btn = '<a href="/admin/character/manage/'.$row->id.'" class="edit btn btn-primary btn-sm">Edit</a>';
                   return $btn;
                })
                ->addColumn('delete', function($row){
                  $btn = '<a href="/admin/character/delete/'.$row->id.'" onclick="return confirm(\'Are you sure you want to delete this item?\')" class="delete btn btn-danger btn-sm">Delete</a>';
                  return $btn;
                })
               ->rawColumns(['status','edit','delete'])
               ->make(true);
            }
          return view('admin.character');  
      }


      public function character_manage(Request $request, $id=''){
           if($id>0){
               $arr=Character::where(['id'=>$id])->get();
               $result['id']=$arr['0']->id;
               $result['character_name']=$arr['0']->character_name;
               $result['character_status']=$arr['0']->character_status;
          } else {
              $result['id']='';
              $result['character_name']='';
              $result['character_status']='';
          }

            return view('admin.character_manage',$result);  
        }

      public function character_insert(Request $request)
      {
    
          if(!$request->input('id')){
              $request->validate([
                 'character_name' => 'required|unique:characters,character_name',
                 'character_status' => 'required',
               ]);
          }else{
              $request->validate([
                 'character_name' => 'required|unique:characters,character_name,'.$request->post('id'),
                 'character_status' => 'required',
              ]);
          }

        $user=Auth::user();
      if($request->post('id')>0){
          $model=Character::find($request->post('id'));
          $model->updated_by=$user->id;
      }else{
           $model= new Character; 
           $model->created_by=$user->id;
       }
          $model->character_name=$request->input('character_name');
          $model->character_status=$request->input('character_status');
          $model->save();

          return redirect('/admin/character')->with('success', 'Changes saved successfully.');

      }


      public function character_delete(Request $request,$id){          
          $model=Character::find($id);
          $model->delete();
          return back()->with('success','Data deleted successfully.');
       }

}
