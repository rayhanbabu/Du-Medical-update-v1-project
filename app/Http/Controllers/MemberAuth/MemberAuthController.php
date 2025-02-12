<?php

namespace App\Http\Controllers\MemberAuth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;
use Illuminate\Support\Facades\DB;
use App\Helpers\MemberJWTToken;
use App\Models\Member;
use App\Models\Service;
use Exception;

class MemberAuthController extends Controller
{
    public function login(Request $request)
    {
        try {
              return view('memberauth.login');
         } catch (Exception $e) {
              return  view('errors.error', ['error' => $e]);
         }
    }


    public function login_insert(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'email' => 'required',
            ],
            [
                'email.required' => 'Email is required',  
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 700,
                'message' => $validator->messages(),
            ]);
        } else {

            $member = Member::where('email', $request->email)->first();
            $status = 1;
            if ($member) {
                    if ($member->member_status == $status) {
                        //$rand = rand(11111, 99999);
                        $rand=12345;
                        DB::update("update members set login_code ='$rand' where email = '$member->email'");
                       // SendEmail($member->email,"Member OTP code", "One Time OTP Code : ",$rand, "ANCOVA");
                        return response()->json([
                            'status' => 200,
                            'code' => $rand,
                            'email' => $member->email,
                        ]);
                    } else {
                        return response()->json([
                            'status' => 600,
                            'message' => 'Acount Inactive',
                        ]);
                    }
                
            } else {
                return response()->json([
                    'status' => 300,
                    'message' => 'Invalid Email',
                ]);
            }
        }
    }


    public function login_verify(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'otp' => 'required|numeric',
            ],
            [
                'otp.required' => 'OTP is required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 700,
                'message' => $validator->messages(),
            ]);
        } else {
               $member = Member::where('email',$request->verify_email)
                    ->where('login_code',$request->otp)->first();
            if ($member) {
                DB::update("update members set login_code ='null' where email = '$member->email'");
                $token_member = MemberJWTToken::CreateToken($member->member_name, $member->email, $member->id ,$member->member_category);
                Cookie::queue('token_member',$token_member, 60*24*2); //96 hour
                  $member_info = [
                    "member_name" => $member->member_name, "email" => $member->email, 
                  ];
                $member_info_array = serialize($member_info);
                Cookie::queue('member_info', $member_info_array, 60 * 24*2);

                return response()->json([
                    'status' => 200,
                    'message' => 'success',
                ]);
            } else {
                return response()->json([
                    'status' => 300,
                    'message' => "Invalid OTP",
                ]);
            }
        }
    }


      public function logout()
       {
          Cookie::queue('token_member', '', -1);
          Cookie::queue('member_info', '', -1);
          return redirect('member/login');
       }


    public function dashboard(Request $request)
     {
          try {
               $service=Service::where('service_status',1)->orderBy('service_name','asc')->get();
               return view('member.dashboard',['service'=>$service]);
           } catch (Exception $e) {
               return  view('errors.error', ['error' => $e]);
           }
      }




}
