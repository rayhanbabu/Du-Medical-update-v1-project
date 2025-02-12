@extends('layouts/dashboardheader')
@section('page_title','Diagnostic Dashboard')
@section('test_manage','active')
@section('content')
 
 <div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
      <div class="row">
        <div class="col-8">
            <h4> Test Report Setup </h4> 
       </div>
       <div class="col-2">
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
       
         </div>
      </div>

      <div class="col-2">
         <div class="d-grid gap-2 d-md-flex ">
            <a class="btn btn-primary btn-sm" href="{{url('/diagnostic/test_list')}}" role="button"> Back </a>
         </div>
      </div>
    </div>


    @if(Session::has('fail'))
    <div class="alert alert-danger"> {{Session::get('fail')}}</div>
    @endif

    @if(Session::has('success'))
    <div class="alert alert-success"> {{Session::get('success')}}</div>
    @endif


  </div>
  <form method="POST" id="edit_test_setup_form" enctype="multipart/form-data">
     <div class="card-body">
      
      <div class="row g-1">
         <div class="col-md-6 mt-2 p-1">
           <div class="shadow p-2">
                 <b> Patient Information </b>
              <hr>
              <div class="row">
                    <div class="col-md-8">
                         Name: <b>{{$testprovide->member_name}} </b><br>
                         Appoinment Id: <b>{{$testprovide->appointment_id}} </b><br>
                         Test Id: <b>{{$testprovide->test_id}} </b><br>
                         Reg/ Employee Id: <b> {{$testprovide->registration}} </b><br>
                         Referred By: <b> {{$testprovide->name}} </b><br>
                         
                     </div>

                     <div class="col-md-4">
                          Age:<b> {{$testprovide->age}} </b><br>
                          Gender:<b> {{$testprovide->gender}} </b><br>

                  @if(admin_info()->userType=="Test")

                  @else
                  <div class="form-group   my-2">
                      <label class=""><b>Test Status <span style="color:red;"> * </span> </b></label>
                      <select class="form-select form-select-sm" name="test_status"  aria-label="Default select example">
                          <option value="1" {{ $testprovide->test_status == '1' ? 'selected' : '' }}> Completed </option>
                          <option value="5" {{ $testprovide->test_status == '5' ? 'selected' : '' }}> Verify Pending </option>
                          <option value="0" {{ $testprovide->test_status == '0' ? 'selected' : '' }}> Staff Pending </option>
                      </select>
                  </div> 
                @endif

                     </div>
              </div>

              <br>
          </div>
      </div>


     <!-- Nursing Start -->
    <div class="col-md-6 mt-2 p-1">
        <div class="shadow p-2">
             Test Name: <b> {{$testprovide->test_name}}</b> 
            <hr>
            <input type="hidden" name="appointment_id" value="{{$testprovide->appointment_id}}" class="form-control"> 
            <input type="hidden" name="test_id" value="{{$testprovide->test_id}}" class="form-control"> 
            <input type="hidden" name="testprovide_id" value="{{$testprovide->id}}" class="form-control"> 
            
    <div class="row">
     <div class="col-md-12">
      <table class="table">
    <tbody>

          @foreach($diagnostic_list as $row)
           <tr>
             @if($table=="diagnostics")
               <input type="hidden" name="diagnostic_id[]" value="{{$row->id}}" class="form-control">
             @else 
             <input type="hidden" name="diagnostic_id[]" value="{{$row->diagnostic_id}}" class="form-control">
             @endif   
               <td> {{$row->diagnostic_name}} </td>
               <input type="hidden" name="character_id[]" value="{{$row->character_id}}" class="form-control">  
               <td> <input type="test" name="result[]" value="{{$row->result}}" class="form-control" required> </td>
               <td> <input type="test" name="reference_range[]" value="{{$row->reference_range}}" class="form-control" readonly> </td>
             
            </tr>
          @endforeach
          
  </tbody>
</table>
                    </div> 
              </div>
          </div>
      </div>
       <!-- Nursing END -->

        <div class="loader">
               <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
       </div>

       <div class="mt-4">
             <button type="submit" id="edit_appointment_btn" class="btn btn-success">Update </button>
       </div>

    </div>
  
    </form>
 


</div>

<script src="{{ asset('js/diagnostic_setup.js') }}"></script>
<script type="text/javascript">
  
    $(".js-example-disabled-results").select2();
    $('.js-example-basic-multiple').select2();

  
  </script>


@endsection



