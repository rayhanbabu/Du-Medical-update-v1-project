@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('role_access','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
       <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> Role Access  @if(!$id) Add @else Edit @endif </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                           <a class="btn btn-primary btn-sm" href="{{url('admin/role_access')}}" role="button"> Back </a>
                         </div>
                     </div> 
         </div>

       @if ($errors->any())
          <div class="alert alert-danger">
             <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
           </div>
       @endif

            @if(Session::has('fail'))
                <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
            @endif
                           
             @if(Session::has('success'))
                   <div  class="alert alert-success"> {{Session::get('success')}}</div>
             @endif

  </div>



  <div class="card-body">    
  <form method="post" action="{{url('admin/role_access/insert')}}"  class="myform"  enctype="multipart/form-data" >
  {!! csrf_field() !!}

     <input type="hidden" name="id"  value="{{$id}}" class="form-control" >

     <div class="row px-2">

          <div class="form-group col-sm-4 my-2">
               <label class=""><b>Name <span style="color:red;"> * </span></b></label>
               <input type="text" name="name" class="form-control" value="{{$name}}" required>
          </div> 

           <div class="form-group col-sm-4 my-2">
               <label class=""><b>E-mail <span style="color:red;"> * </span></b></label>
               <input type="text" name="email"  class="form-control" value="{{$email}}" required>
           </div> 


          <div class="form-group col-sm-4 my-2">
               <label class=""><b>Phone Number <span style="color:red;"> * </span></b></label>
                 <input name="phone" id="phone" type="text" pattern="[0][1][3 7 6 5 8 9][0-9]{8}" title="
				            Please select Valid mobile number" value="{{$phone}}" class="form-control" required />
          </div> 

            <div class="form-group col-sm-4  my-2">
                <label class=""> <b> Designation <span style="color:red;"> * </span></b> </label>
                <input type="text" name="designation" value="{{$designation}}" class="form-control" required>
            </div> 
     
            
      <div class="form-group col-sm-4 my-2">
        <label class=""><b> User Type <span style="color:red;"> * </span> </b></label>
         <select class="form-select" name="userType" id="userType" aria-label="Default select example">
             <option value="Doctor" {{ $userType == 'Doctor' ? 'selected' : '' }}>Doctor</option>
             <option value="Nursing" {{ $userType == 'Nursing' ? 'selected' : '' }}>Nursing</option>
             <option value="Pharmacy" {{ $userType == 'Pharmacy' ? 'selected' : '' }}>Pharmacy</option>
             <option value="Staff" {{ $userType == 'Staff' ? 'selected' : '' }}>Staff</option>
             <option value="Homeopathy" {{ $userType == 'Homeopathy' ? 'selected' : '' }}>Homeopathy</option>
             <option value="Test" {{ $userType == 'Test' ? 'selected' : '' }}>Test</option>
             <option value="Pathologist" {{ $userType == 'Pathologist' ? 'selected' : '' }}>Pathologist</option>
             <option value="Ward" {{ $userType == 'Ward' ? 'selected' : '' }}>Ward</option>
             <option value="Driver" {{ $userType == 'Driver' ? 'selected' : '' }}>Driver</option>
         </select>
     </div>

      <div class="form-group col-sm-4 my-2">
         <label><b> Offline Registration & Appointment Access </b></label>
           <select class="form-select" name="offline_reg_access" id="offline_reg_access" aria-label="Default select example">
              <option value="No" {{ $offline_reg_access == 'No' ? 'selected' : '' }}>No</option>
              <option value="Yes" {{ $offline_reg_access == 'Yes' ? 'selected' : '' }}>Yes</option>
           </select>
      </div>

           <div class="form-group col-sm-2  my-2">
                <label class=""><b> Report Access </b></label>
                 <select class="form-select" name="reports_access" id="reports_access"  aria-label="Default select example">
                     <option value="No" {{ $reports_access == 'No' ? 'selected' : '' }}>No</option>
                     <option value="Yes" {{ $reports_access == 'Yes' ? 'selected' : '' }}>Yes</option>
                </select>
           </div> 

           <div class="form-group col-sm-2  my-2">
                <label class=""><b>Patient Report Access </b></label>
                 <select class="form-select" name="patient_report_access" id="patient_report_access"  aria-label="Default select example">
                      <option value="No" {{ $patient_report_access == 'No' ? 'selected' : '' }}>No</option>
                      <option value="Yes" {{ $patient_report_access == 'Yes' ? 'selected' : '' }}>Yes</option>
                </select>
           </div> 


           <div class="form-group col-sm-2  my-2">
                <label class=""><b> Oncall Access </b></label>
                 <select class="form-select" name="oncall_access" id="oncall_access"  aria-label="Default select example">
                      <option value="No" {{ $oncall_access == 'No' ? 'selected' : '' }}>No</option>
                      <option value="Yes" {{ $oncall_access == 'Yes' ? 'selected' : '' }}>Yes</option>
                </select>
           </div>
   

           <div class="form-group col-sm-2  my-2">
                <label class=""> <b> Image </b> </label>
                <input type="file" name="image" class="form-control" >
            </div> 

            <div class="form-group col-sm-2  my-2">
                <label class=""> <b> Signature Image </b> </label>
                <input type="file" name="image2" class="form-control" >
            </div> 

            <div class="form-group col-sm-2  my-2">
                <label class=""> <b> Serial </b> </label>
                <input type="number" name="serial" value="" class="form-control" >
            </div> 

          @if(!$id)
            <div class="form-group col-sm-4  my-2">
                <label class=""> <b> Password <span style="color:red;"> * </span></b> </label>
                <input type="password" name="password" class="form-control" required>
           </div> 

            <div class="form-group col-sm-4  my-2">
                <label class=""> <b>Confirm Password <span style="color:red;"> * </span></b> </label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
            @endif


         
            @if($id)
            <div class="form-group col-sm-4  my-2">
                <label class=""><b> Status </b></label>
                 <select class="form-select" name="status"  aria-label="Default select example">
                      <option value="1" {{ $status == '1' ? 'selected' : '' }}>Active</option>
                      <option value="0" {{ $status == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
           </div> 
            @endif
          
            @if($id)
            <div class="form-group col-sm-8  my-2">
                <label class=""><b> Tests Access </b></label>
           <select class="js-example-basic-multiple form-control" name="tests_id[]" id="tests_id" multiple="multiple">                       
                @foreach($test as $row)
                  <option value="{{ $row->id }}" 
                         @foreach($tests as $row1){{ $row1==$row->id ? 'selected': ''}}   @endforeach > {{ $row->test_name }}
                  </option>
                @endforeach  
           </select>

           </div> 
            @endif


            <div class="form-group col-sm-4  my-2">
                <label class=""> <b> Degree </b> </label>
                <input type="text" name="degree" value="{{$degree}}" class="form-control" >
            </div> 

            <div class="form-group col-sm-4  my-2">
                <label class=""> <b> Department </b> </label>
                <input type="text" name="department" value="{{$department}}" class="form-control" >
            </div> 

            <div class="form-group col-sm-4  my-2">
                <label class=""> <b> Doctor Type </b> </label>
                <input type="text" name="doctor_type" value="{{$doctor_type}}" class="form-control" >
            </div> 



       </div>
           <br>
        <input type="submit"   id="insert" value="Submit" class="btn btn-success" />
	  
              
     </div>

     </form>

  </div>
</div>



    <script type="text/javascript">
        $('.js-example-basic-multiple').select2();
    </script>


@endsection