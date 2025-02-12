<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content=""/>
        <meta name="author" content="MD Rayhan Babu"/>
        <title> ANCOVA Admin Panel </title>
        <link rel="icon" type="image/png" href="{{asset('images/ancovabr.png')}}">
      

        <link rel="stylesheet" href="{{asset('dashboardfornt/css/styles.css')}}">
        <!-- <link rel="stylesheet" href="{{asset('dashboardfornt/css/solaiman.css')}}"> -->
        <link rel="stylesheet" href="{{asset('dashboardfornt/css/dataTables.bootstrap5.min.css')}}">
        <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
   
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />


        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <script src="{{asset('dashboardfornt\js\jquery-3.5.1.js')}}"></script>
        <script src="{{asset('dashboardfornt\js\bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('dashboardfornt\js\jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('dashboardfornt\js\dataTables.bootstrap5.min.js')}}"></script>
        <script src="{{asset('dashboardfornt/js/sweetalert.min.js')}}"></script>
        <script src="{{asset('dashboardfornt/js/scripts.js')}}"></script>

        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
         <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
      

         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"  />
          <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" ></script>
	    
    </head>


 
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-light bg-primary text-white">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3 text-white"  href="#"  > DUMC</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-5 me-lg-0 text-white" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">

                @if(Auth::user())
                   {{ Auth::user()->name }}
                 @endif
                </div>
            </form>
            <!-- Navbar-->


            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                         <li><a class="dropdown-item" href="{{ url('/companypay')}}">Payment</a></li>
                         <li><a class="dropdown-item" href="{{ url('admin/password')}}">Password Change</a></li>
                         <li><hr class="dropdown-divider" /></li>
                         <li><a class="dropdown-item" href="{{ url('admin/logout')}}">Logout</a></li>
                      </ul>
                </li>
            </ul>
        </nav>


<div id="layoutSidenav">
  <div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
     <div class="sb-sidenav-menu">
       <div class="nav">
                           					   
       <a class="nav-link @yield('admin_select') " href="{{url('admin/dashboard')}}">
          <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
             Dashboard
       </a>
		
      
     
   @if(admin_access())  
     <a class="nav-link @yield('Executive_select')  @yield('Advisor_select') @yield('Senior_select') @yield('General_select')
           collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
        <div class="sb-nav-link-icon "><i class="fas fa-columns"></i></div>
             Setting
         <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
     </a>
        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
        <nav class="sb-sidenav-menu-nested nav">
             <a class="nav-link @yield('role_access')" href="{{url('/admin/role_access')}}"> Role Access </a>
             <a class="nav-link @yield('chamber_setup')" href="{{url('/admin/chamber')}}"> Chamber Setup </a> 
             <a class="nav-link @yield('service')" href="{{url('/admin/service')}}"> Service </a> 
             <a class="nav-link @yield('generic')" href="{{url('/admin/generic')}}"> Generic </a> 
             <a class="nav-link @yield('brand')" href="{{url('/admin/brand')}}"> Brand </a>   
             <a class="nav-link @yield('week')" href="{{url('/admin/week')}}"> Week </a> 
             <a class="nav-link @yield('testcategory')" href="{{url('/admin/testcategory')}}"> Test Category </a>  
             <a class="nav-link @yield('character')" href="{{url('/admin/character')}}"> Test Character</a> 
             <a class="nav-link @yield('test')" href="{{url('/admin/test')}}"> Test </a>
             <a class="nav-link @yield('dutytime')" href="{{url('/admin/dutytime')}}"> Duty Time Setup </a> 
         </nav>
      </div>


      <a class="nav-link @yield('Executive_select') 
            collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts16" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon "><i class="fas fa-columns"></i></div>
            Web Staff Schedule 
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
       </a>
         <div class="collapse" id="collapseLayouts16" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                @foreach(user_type() as $row)
                  <a class="nav-link @yield('UserType')" href="{{url('/admin/staffduty/'.$row->userType)}}"> {{$row->userType }} </a>  
                @endforeach   
            </nav>
         </div>



         <a class="nav-link @yield('Executive_select') 
            collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts15" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon "><i class="fas fa-columns"></i></div>
            Web Customize
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
       </a>
         <div class="collapse" id="collapseLayouts15" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
                <a class="nav-link @yield('pagecategory')" href="{{url('/admin/pagecategory')}}"> Page Create </a>
                @foreach(page_cagetory() as $row)
                  <a class="nav-link @yield('notice'.$row->page_id)" href="{{url('/admin/notice/'.$row->page_id)}}"> {{$row->page_name }} </a>  
                @endforeach   
            </nav>
         </div>


         <a class="nav-link @yield('stock')" href="{{url('admin/stock')}}">
            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Medicine Stock
         </a>


      @endif
 
       
     @if(registration_access())
     
           <a class="nav-link @yield('member') " href="{{url('admin/member')}}">
            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                  Patient Information 
           </a>

           <a class="nav-link @yield('appointment') " href="{{url('admin/appointment')}}">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                  Make an Appointment 
            </a>
      @endif

         @if(doctor_access())
          <a class="nav-link @yield('appointment_list') " href="{{url('doctor/appointment_list')}}">
             <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Doctor Appointment 
          </a>
         @endif

        @if(diagnostic_access())
            <a class="nav-link @yield('test_list') " href="{{url('/diagnostic/test_list')}}">
               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                  Diagnostic Panel 
            </a>

          <a class="nav-link @yield('appointment_test')" href="{{url('diagnostic/appointment_test')}}">
             <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                 Test Report
          </a>

         @endif

         @if(pharmacy_access())
            <a class="nav-link @yield('medicine_list') " href="{{url('/pharmacy/medicine_list')}}">
               <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                 Pharmacy Panel 
            </a>
         @endif

         @if(nursing_access())
            <a class="nav-link @yield('nursing_list')" href="{{url('/nursing/nursing_list')}}">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                 Nursing Panel 
            </a>
         @endif  

         @if(ward_access())
           <a class="nav-link @yield('ward_list')" href="{{url('/ward/ward_list')}}">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Isolation Ward
           </a>
         @endif 

         @if(driver_access())  
          <a class="nav-link @yield('ambulance') " href="{{url('ambulance/ambulance')}}">
            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Ambulance Panel 
           </a>
         @endif


         @if(oncall_access())
            <a class="nav-link @yield('oncall') " href="{{url('/oncall/oncall')}}">
              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                 On Call Service
            </a>
         @endif

      

       @if(patient_report_access())
        <a class="nav-link @yield('Executive_select') 
            collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts12" aria-expanded="false" aria-controls="collapseLayouts">
            <div class="sb-nav-link-icon "><i class="fas fa-columns"></i></div>
                 Patient Report
            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
       </a>
         <div class="collapse" id="collapseLayouts12" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
            <nav class="sb-sidenav-menu-nested nav">
               <a class="nav-link @yield('appointment')" href="{{url('/patientreport/appointment')}}"> Appointment </a>
               <a class="nav-link @yield('diagnostic')" href="{{url('/patientreport/diagnostic')}}"> Diagnostic </a> 
               <a class="nav-link @yield('pharmacy')" href="{{url('/patientreport/pharmacy')}}"> Pharmacy </a>   
            </nav>
         </div>
     @endif


     @if(report_access())
      <a class="nav-link @yield('Executive_select') 
         collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts13" aria-expanded="false" aria-controls="collapseLayouts">
        <div class="sb-nav-link-icon "><i class="fas fa-columns"></i></div>
            Medicine Report
         <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
      </a>
         <div class="collapse" id="collapseLayouts13" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
         <nav class="sb-sidenav-menu-nested nav">
              <a class="nav-link @yield('role_access')" href="{{url('/report/medicine_available')}}">Available Medicine</a>
              <a class="nav-link @yield('service')" href="{{url('/report/medicine')}}">Overall Reports</a>  
         </nav>
     </div>

       <a class="nav-link @yield('report_appointment')" href="{{url('/report/appointment')}}">
            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Appointment Report
         </a>


         <a class="nav-link @yield('report_diagnostic')" href="{{url('/report/diagnostic')}}">
            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Diagnostic Report
         </a>

         <a class="nav-link @yield('report_nursing')" href="{{url('/report/nursing')}}">
            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Nursing Report
         </a>

         <a class="nav-link @yield('report_ambulance')" href="{{url('/report/ambulance')}}">
            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
              Ambulance Report
         </a>

         <a class="nav-link @yield('report_rating')" href="{{url('/report/rating')}}">
            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
               Rating Report
         </a>
      @endif





    
  </div>
 </div>
                   
<!-- <div class="sb-sidenav-footer">
     <div class="small">Developed By:</div>
          ANCOVA
      </div> -->
   </nav>
</div>


<div id="layoutSidenav_content">
<main>

<div class="container-fluid px-3 p-2">

      <div>
                 @yield('content')
             
     </div>


</div>    

    </main>
               
            </div>
        </div> 

       
       

        
        
    
    
    </body>
</html>
