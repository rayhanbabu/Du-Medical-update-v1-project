<?php
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\WeekController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\DiagnosticController;
use App\Http\Controllers\Admin\ChamberController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\SlotController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Diagnostic\DiagnosticpanelController;
use App\Http\Controllers\Doctor\AppointmentListController;
use App\Http\Controllers\Pharmacy\PharmacypanelController;
use App\Http\Controllers\Nursing\NursingpanelController;
use App\Http\Controllers\Ward\WardpanelController;
use App\Http\Controllers\Admin\GenericController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\StockController;
use App\Http\Controllers\Ambulance\AmbulancepanelController;
use App\Http\Controllers\Oncall\OncallpanelController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\TestcategoryController;
use App\Http\Controllers\MemberAuth\MemberAuthController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\PatientReport\PatientReportController;
use App\Http\Controllers\MemberPanel\MemberPanelController;
use App\Http\Controllers\MemberPanel\MyAppointmentController;
use App\Http\Controllers\Report\MedicineReportController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Admin\DutyTimeController;
use App\Http\Controllers\WebCustomize\PageCategoryController;
use App\Http\Controllers\Admin\CharacterController;
use App\Http\Controllers\WebCustomize\NoticeController;
use App\Http\Controllers\WebCustomize\StaffdutyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

       //  Route::get('/', function () {
       //      return view('welcome');
       //   });

          Route::get('/prescripsion_update', function () {
            return view('patientreportprint.prescription_update');
         });

       Route::get('/', [HomeController::class,'index']);
       Route::get('/service', [HomeController::class,'service']);
       Route::get('/member_information/{member}', [HomeController::class,'doctor']);
       Route::get('/doctor-details/{id}',[HomeController::class,'doctor_details']);
       Route::get('/notice-details/{id}',[HomeController::class,'notice_details']);
       Route::get('/page-view/{id}',[HomeController::class,'page_view']);
       Route::get('/service-form/{id}',[HomeController::class,'service_form']);
       Route::get('/service-schedule/{service_name}',[HomeController::class,'service_schedule']);
       Route::get('/staff-schedule',[HomeController::class,'staff_schedule']);

       //Route::get('/users', [UserController::class,'user_show'])->name('users.index');

      Route::middleware('auth')->group(function () {

          Route::get('/admin/dashboard', [AdminController::class,'index']);
          Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
          Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
          Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
          Route::get('admin/logout', [AuthenticatedSessionController::class, 'destroy']);

          //patient Report Print
          Route::get('/prescription/{appointment_id}', [PatientReportController::class,'prescription_show']);
          Route::get('/diagnostic/report/{appointment_id}/{testcategory_id}', [PatientReportController::class,'diagnostic_report']);
     });
 
      //admin route
      Route::middleware(['AdminMiddleware'])->group(function (){
          
            //role Access
            Route::get('/admin/role_access', [AdminController::class,'role_access']);
            Route::get('/admin/role_access/manage', [AdminController::class,'role_access_manage']);
            Route::get('/admin/role_access/manage/{id}', [AdminController::class,'role_access_manage']);
            Route::post('/admin/role_access/insert', [AdminController::class,'role_access_insert']);
            Route::get('/admin/role_access/delete/{id}', [AdminController::class,'role_access_delete']);
          
            //Service 
            Route::get('/admin/service', [ServiceController::class,'service']);
            Route::get('/admin/service/manage', [ServiceController::class,'service_manage']);
            Route::get('/admin/service/manage/{id}', [ServiceController::class,'service_manage']);
            Route::post('/admin/service/insert', [ServiceController::class,'service_insert']);
            Route::get('/admin/service/delete/{id}', [ServiceController::class,'service_delete']);

            //generic 
            Route::get('/admin/generic', [GenericController::class,'generic']);
            Route::get('/admin/generic/manage', [GenericController::class,'generic_manage']);
            Route::get('/admin/generic/manage/{id}', [GenericController::class,'generic_manage']);
            Route::post('/admin/generic/insert', [GenericController::class,'generic_insert']);
            Route::get('/admin/generic/delete/{id}', [GenericController::class,'generic_delete']);

            //brand 
            Route::get('/admin/brand', [BrandController::class,'brand']);
            Route::get('/admin/brand/manage', [BrandController::class,'brand_manage']);
            Route::get('/admin/brand/manage/{id}', [BrandController::class,'brand_manage']);
            Route::post('/admin/brand/insert', [BrandController::class,'brand_insert']);
            Route::get('/admin/brand/delete/{id}', [BrandController::class,'brand_delete']); 

           //medicine 
           Route::get('/admin/medicine',[MedicineController::class,'medicine']);
           Route::get('/admin/medicine/manage',[MedicineController::class,'medicine_manage']);
           Route::get('/admin/medicine/manage/{id}',[MedicineController::class,'medicine_manage']);
           Route::post('/admin/medicine/insert',[MedicineController::class,'medicine_insert']);
           Route::get('/admin/medicine/delete/{id}',[MedicineController::class,'medicine_delete']);


           //Stock 
           Route::get('/admin/stock', [StockController::class,'stock']);
           Route::get('/admin/stock/manage', [StockController::class,'stock_manage']);
           Route::get('/admin/stock/manage/{id}', [StockController::class,'stock_manage']);
           Route::post('/admin/stock/insert', [StockController::class,'stock_insert']);
           Route::get('/admin/stock/delete/{id}', [StockController::class,'stock_delete']);
        
           //week 
           Route::get('/admin/week', [WeekController::class,'week']);
           Route::get('/admin/week/manage', [WeekController::class,'week_manage']);
           Route::get('/admin/week/manage/{id}', [WeekController::class,'week_manage']);
           Route::post('/admin/week/insert', [WeekController::class,'week_insert']);
           Route::get('/admin/week/delete/{id}', [WeekController::class,'week_delete']);

          //testcategory 
          Route::get('/admin/testcategory',[TestcategoryController::class,'testcategory']);
          Route::get('/admin/testcategory/manage',[TestcategoryController::class,'testcategory_manage']);
          Route::get('/admin/testcategory/manage/{id}',[TestcategoryController::class,'testcategory_manage']);
          Route::post('/admin/testcategory/insert',[TestcategoryController::class,'testcategory_insert']);
          Route::get('/admin/testcategory/delete/{id}',[TestcategoryController::class,'testcategory_delete']);

            //test 
            Route::get('/admin/test', [TestController::class,'test']);
            Route::get('/admin/test/manage', [TestController::class,'test_manage']);
            Route::get('/admin/test/manage/{id}', [TestController::class,'test_manage']);
            Route::post('/admin/test/insert', [TestController::class,'test_insert']);
            Route::get('/admin/test/delete/{id}', [TestController::class,'test_delete']);

             //diagnostic 
            Route::get('/admin/diagnostic/{test_id}', [DiagnosticController::class,'diagnostic']);
            Route::get('/admin/diagnostic/manage/{test_id}', [DiagnosticController::class,'diagnostic_manage']);
            Route::get('/admin/diagnostic/manage/{test_id}/{id}', [DiagnosticController::class,'diagnostic_manage']);
            Route::post('/admin/diagnostic/insert', [DiagnosticController::class,'diagnostic_insert']);
            Route::get('/admin/diagnostic/delete/{id}', [DiagnosticController::class,'diagnostic_delete']);
       
           // Diagnostic character 
           Route::get('/admin/character', [CharacterController::class,'character']);
           Route::get('/admin/character/manage', [CharacterController::class,'character_manage']);
           Route::get('/admin/character/manage/{id}', [CharacterController::class,'character_manage']);
           Route::post('/admin/character/insert', [CharacterController::class,'character_insert']);
           Route::get('/admin/character/delete/{id}', [CharacterController::class,'character_delete']);

            //chamber 
            Route::get('/admin/chamber', [ChamberController::class,'chamber']);
            Route::get('/admin/chamber/manage', [ChamberController::class,'chamber_manage']);
            Route::get('/admin/chamber/manage/{id}', [ChamberController::class,'chamber_manage']);
            Route::post('/admin/chamber/insert', [ChamberController::class,'chamber_insert']);
            Route::get('/admin/chamber/delete/{id}', [ChamberController::class,'chamber_delete']);

            //slot 
            Route::get('/admin/slot/{chamber_id}', [SlotController::class,'slot']);
            Route::get('/admin/slot/manage/{chamber_id}/{week_name}', [SlotController::class,'slot_manage']);
            Route::get('/admin/slot/manage/{chamber_id}/{week_name}/{id}', [SlotController::class,'slot_manage']);
            Route::post('/admin/slot/insert', [SlotController::class,'slot_insert']);
            Route::get('/admin/slot/delete/{id}', [SlotController::class,'slot_delete']);

           //dutytime 
           Route::get('/admin/dutytime', [DutyTimeController::class,'dutytime']);
           Route::get('/admin/dutytime/manage', [DutyTimeController::class,'dutytime_manage']);
           Route::get('/admin/dutytime/manage/{id}', [DutyTimeController::class,'dutytime_manage']);
           Route::post('/admin/dutytime/insert', [DutyTimeController::class,'dutytime_insert']);
           Route::get('/admin/dutytime/delete/{id}', [DutyTimeController::class,'dutytime_delete']);


        //website customize 
            
            //pagecategory 
             Route::get('/admin/pagecategory', [PageCategoryController::class,'pagecategory']);
             Route::get('/admin/pagecategory/manage', [PageCategoryController::class,'pagecategory_manage']);
             Route::get('/admin/pagecategory/manage/{id}', [PageCategoryController::class,'pagecategory_manage']);
             Route::post('/admin/pagecategory/insert', [PageCategoryController::class,'pagecategory_insert']);
             Route::get('/admin/pagecategory/delete/{id}', [PageCategoryController::class,'pagecategory_delete']);
         
             // Web Page
             Route::get('/admin/notice/{pagecategory_id}',[NoticeController::class,'notice']);
             Route::get('/admin/notice/manage/{pagecategory_id}',[NoticeController::class,'notice_manage']);
             Route::get('/admin/notice/manage/{pagecategory_id}/{id}',[NoticeController::class,'notice_manage']);
             Route::post('/admin/notice/insert', [NoticeController::class,'notice_insert']);
             Route::get('/admin/notice/delete/{id}', [NoticeController::class,'notice_delete']);

          
             //staffduty 
             Route::get('/admin/staffduty/{userType}', [StaffdutyController::class,'staffduty']);
             Route::get('/admin/staffduty/manage/{userType}', [StaffdutyController::class,'staffduty_manage']);
             Route::get('/admin/staffduty/manage/{userType}/{id}', [StaffdutyController::class,'staffduty_manage']);
             Route::post('/admin/staffduty/insert', [StaffdutyController::class,'staffduty_insert']);
             Route::get('/admin/staffduty/delete/{id}', [StaffdutyController::class,'staffduty_delete']);
      
            });


        //Member login
        Route::get('/member/login',[MemberAuthController::class,'login'])->middleware('MemberTokenExist');
        Route::post('/member/login-insert',[MemberAuthController::class,'login_insert']);
        Route::post('/member/login-verify',[MemberAuthController::class,'login_verify']);
       

        Route::middleware('MemberToken')->group(function(){ 
             Route::get('/member/logout',[MemberAuthController::class,'logout']);
             Route::get('/member/dashboard',[MemberAuthController::class,'dashboard']);
             Route::get('/service/search',[MemberPanelController::class,'service_search']);
               //appointment
             Route::get('/member/appointment_cart/{slot_id}/{date}',[MemberPanelController::class,'appointment_cart']);
             Route::get('/member/appointment_delete/{appointment_id}',[MemberPanelController::class,'appointment_delete']);
             Route::post('/member/appointment/update',[MemberPanelController::class,'appointment_update']);
     
             Route::get('/my-appointment',[MyAppointmentController::class,'my_appointment']);
             Route::get('/appointment/feedback',[MyAppointmentController::class,'appointment_feedback']); 
             Route::get('/appointment/slip',[MyAppointmentController::class,'appointment_slip']);    

          }); 
        

         Route::middleware('DoctorMiddleware')->group(function(){
              //Doctor  Appointment List  
              Route::get('/doctor/appointment_list',[AppointmentListController::class,'appointment_list']);
              Route::get('/doctor/appointment/setup/{appoinment_id}',[AppointmentListController::class,'appointment_setup']);
              Route::post('/doctor/appointment/setup/update',[AppointmentListController::class,'appointment_setup_update']);
              Route::get('/doctor/inmedicine/delete/{medicine_id}',[AppointmentListController::class,'inmedicine_delete']);
              Route::get('/doctor/outmedicine/delete/{outmedicine_id}',[AppointmentListController::class,'outmedicine_delete']);
              Route::get('/doctor/intest/delete/{intest_id}',[AppointmentListController::class,'intest_delete']);
              Route::get('/doctor/outtest/delete/{outtest_id}',[AppointmentListController::class,'outtest_delete']);
           });  

       Route::middleware('NursingMiddleware')->group(function(){
             //Nursing Panel
             Route::get('/nursing/nursing_list',[NursingpanelController::class,'nursing_list']);
             Route::get('/nursing/setup',[NursingpanelController::class,'nursing_setup']);
             Route::post('/nursing/search',[NursingpanelController::class,'nursing_search']);
           
             Route::post('/nursing/insert',[NursingpanelController::class,'nursing_insert']);
             Route::get('/nursing/nursing_service/{appointment_id}',[NursingpanelController::class,'nursing_service']);
             Route::delete('/nursing/delete',[NursingpanelController::class,'nursing_delete']);
             Route::get('/nursing/status/{type}/{appintment_id}',[NursingpanelController::class,'nursing_status']);

             Route::get('/nursing/nursing_report/{appointment_id}',[NursingpanelController::class,'nursing_report']);
       
            });  

       Route::middleware('PharmacyMiddleware')->group(function(){
           //Pharmacy Panel
           Route::get('/pharmacy/medicine_list',[PharmacypanelController::class,'medicine_list']);
           Route::delete('/pharmacy/medicine_status',[PharmacypanelController::class,'medicine_status']);
        }); 


        Route::middleware('DiagnosticMiddleware')->group(function(){
             //Diagnostic Panel
             Route::get('/diagnostic/test_list',[DiagnosticpanelController::class,'test_list']);
             Route::get('/diagnostic/setup',[DiagnosticpanelController::class,'diagnostic_setup']);
             Route::post('/diagnostic/search',[DiagnosticpanelController::class,'diagnostic_search']);
             Route::post('/diagnostic/setup/update',[DiagnosticpanelController::class,'diagnostic_setup_update']);
             Route::get('/diagnostic/intest/delete/{test_id}',[DiagnosticpanelController::class,'intest_delete']);

             Route::get('/diagnostic/test_report/{appointment_id}/{testcategory_id}',[DiagnosticpanelController::class,'test_report']);
             Route::post('/diagnostic/test_report/update',[DiagnosticpanelController::class,'test_report_update']);            
         }); 


       Route::middleware('WardMiddleware')->group(function(){
            //Ward Panel
           Route::get('/ward/ward_list',[WardpanelController::class,'ward_list']);
           Route::get('/ward/setup',[WardpanelController::class,'ward_setup']);
           Route::post('/ward/search',[WardpanelController::class,'ward_search']);

           Route::get('/ward/ward_report/{appointment_id}',[WardpanelController::class,'ward_report']);
           Route::post('/ward/insert',[WardpanelController::class,'ward_insert']);
           Route::get('/ward/edit/{id}',[WardpanelController::class,'ward_edit']);
           Route::post('/ward/update',[WardpanelController::class,'ward_update']);
           Route::get('/ward/ward_service/{appointment_id}',[WardpanelController::class,'ward_service']);
           Route::delete('/ward/delete',[WardpanelController::class,'ward_delete']);
           Route::get('/ward/status/{type}/{appintment_id}',[WardpanelController::class,'ward_status']);
       }); 

      Route::middleware('DriverMiddleware')->group(function(){
          //ambulance Panel
          Route::get('/ambulance/ambulance',[AmbulancepanelController::class,'ambulance']);
          Route::delete('/ambulance/ambulance_status',[AmbulancepanelController::class,'ambulance_status']);
          Route::post('/ambulance/insert',[AmbulancepanelController::class,'ambulance_insert']);
          Route::get('/ambulance/edit/{id}',[AmbulancepanelController::class,'ambulance_edit']);
          Route::post('/ambulance/update',[AmbulancepanelController::class,'ambulance_update']);
          Route::delete('/ambulance/delete',[AmbulancepanelController::class,'delete']);
       });  


       Route::middleware('RegistrationMiddleware')->group(function(){
           // Member  
           Route::get('/admin/member',[MemberController::class,'member']);
           Route::post('/admin/member/insert',[MemberController::class,'store']);
           Route::get('/admin/member_view/{id}',[MemberController::class,'edit']);
           Route::post('/admin/member/update',[MemberController::class,'update']);
           Route::delete('/admin/member/delete',[MemberController::class,'delete']);

           // family 
           Route::get('/admin/family/{member_id}', [FamilyController::class,'family']);
           Route::get('/admin/family/manage/{member_id}', [FamilyController::class,'family_manage']);
           Route::get('/admin/family/manage/{member_id}/{id}',[FamilyController::class,'family_manage']);
           Route::post('/admin/family/insert',[FamilyController::class,'family_insert']);
           Route::get('/admin/family/delete/{id}',[FamilyController::class,'family_delete']);

            // Appointment Create  
            Route::get('/admin/appointment',[AppointmentController::class,'appointment']);
            Route::post('/admin/appointment/search',[AppointmentController::class,'appointment_search']);
            Route::post('/admin/appointment/update',[AppointmentController::class,'appointment_update']);


            Route::get('/admin/appointment_cart/{slot_id}',[AppointmentController::class,'appointment_cart']);
            Route::get('/admin/appointment_delete/{appointment_id}',[AppointmentController::class,'appointment_delete']);
          
         }); 


      Route::middleware('ReportMiddleware')->group(function(){  
         
             //Report Medicine
              Route::get('/report/medicine',[MedicineReportController::class,'report_medicine']);
              Route::get('/report/medicine_available',[MedicineReportController::class,'report_medicine_available']);
              Route::post('reportprint/medicine/datewise_provide',[MedicineReportController::class,'datewise_provide']);

              //Report Service Appointment
              Route::get('/report/appointment',[ReportController::class,'report_appointment']);
              Route::post('/reportdompdf/doctor-appointment',[ReportController::class,'doctor_appointment']);
  
              //Report Service Diagnostic
              Route::get('/report/diagnostic',[ReportController::class,'report_diagnostic']);

              //Report Nursing
              Route::get('/report/nursing',[ReportController::class,'report_nursing']);
 
              //Report Ambulance
              Route::get('/report/ambulance',[ReportController::class,'report_ambulance']);

              //Report Rating
              Route::get('/report/rating',[ReportController::class,'report_rating']);
        });


       Route::middleware('PatientReportMiddleware')->group(function(){    
            // Patient Report Controller
            Route::get('/patientreport/appointment',[PatientReportController::class,'patient_report_appointment']);
            Route::post('/patientreport/appointment_show',[PatientReportController::class,'patient_report_appointment_show']);
            
            Route::get('/patientreport/diagnostic',[PatientReportController::class,'patient_report_diagnostic']);
            Route::post('/patientreport/diagnostic_show',[PatientReportController::class,'patient_report_diagnostic_show']);
            Route::get('/patientreport/diagnostic_result/{testprovide_id}',[PatientReportController::class,'patient_report_diagnostic_result']);    
             
            Route::get('/patientreport/pharmacy',[PatientReportController::class,'patient_report_pharmacy']);
            Route::post('/patientreport/pharmacy_show',[PatientReportController::class,'patient_report_pharmacy_show']);  
        });


        Route::middleware('OncallMiddleware')->group(function(){   
              //Oncall Service
              Route::get('/oncall/oncall',[OncallpanelController::class,'oncall']);
              Route::delete('/oncall/oncall_status',[OncallpanelController::class,'oncall_status']);
              Route::post('/oncall/insert',[OncallpanelController::class,'oncall_insert']);
              Route::get('/oncall/edit/{id}',[OncallpanelController::class,'oncall_edit']);
              Route::post('/oncall/update',[OncallpanelController::class,'oncall_update']);
              Route::delete('/oncall/delete',[OncallpanelController::class,'delete']);
        });
    

  require __DIR__.'/auth.php';
