@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('appointment_list','active')
@section('content')
 
 <div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
      <div class="row">
        <div class="col-8">
            <h4> Appointment Setup </h4> 
       </div>
       <div class="col-2">
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <a class="btn btn-primary btn-sm" href="{{url('diagnostic/setup')}}" role="button"> Add </a>
         </div>
      </div>


      <div class="col-2">
        <div class="d-grid gap-2 d-md-flex ">
            <a class="btn btn-primary btn-sm" href="{{url('/doctor/appointment_list')}}" role="button"> Back </a>
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
  <form method="POST" id="edit_appointment_setup_form" enctype="multipart/form-data">
     <div class="card-body">
   
    <div class="row g-1">
       
       <div class="col-md-5 mt-2 p-1">
         <div class="shadow p-2">
              <b> Patient Information </b>
              <hr>
              <div class="row">
                    <div class="col-md-8">
                   
                       
                       Appointment Id:<b> </b> <br>
                       Reg/ Employee Id: <b>  </b><br>
                       Problem Description:<b>  </b>
                     </div>

                     <div class="col-md-4">
                         Age:<b>  Year</b> <br>
                         Gender:<b>  </b> <br>
                         Attached File:<b> </b>
                     </div>
              </div>

              <br>
          </div>
      </div>


     <!-- Nursing Start -->
      <div class="col-md-2 mt-2 p-1">
         <div class="shadow p-2">
              <b> Nursing </b>
              <hr>
              <div class="row">
                  <div class="col-md-12">
                    <div class="form-group p-1">
                     <label class="control-label"> Service </label>
                     <select name="nursing_service" id="nursing_service" class="form-control js-example-disabled-results" style="max-width:300px;" >
                        <option value="">Select One</option>
                     
                   </select>
                       </div>

                      <div class="form-group p-2">
                            <label class=""> Comment(If Any) </label> 
                            <input type="text" id="nursing_comment" value="{{$appointment->nursing_comment}}" name="nursing_comment" class="form-control form-control-sm">
                      </div> 

                    </div> 
              </div>
          </div>
      </div>
       <!-- Nursing END -->

     <!-- Isolation Start -->
      <div class="col-md-2 mt-2 p-1">
         <div class="shadow p-2">
              <b> Isolation </b>
              <hr>
              <div class="row">
                    <div class="col-md-12">
                     

                    </div> 
              </div>
          </div>
      </div>
       <!-- Isolation  END -->


          <!-- Isolation Start -->
      <div class="col-md-3 mt-2 p-1">
         <div class="shadow p-2">
              <b> Advise </b>
              <hr>
              <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                      
                         </div>
                    </div> 
              </div>
          </div>
      </div>
       <!-- Isolation  END -->

     



  <!-- Test In Start -->
 <div class="col-md-3 mt-2 p-1">
      <div class="shadow p-3">
          <b> Test in Medical </b>
       <hr>

     <div id="intest_attr_box" >
                 @php
                      $tiloop_count_num=1;
                      $tiloop_count_prev=$tiloop_count_num;
                 @endphp
     
           @foreach($intestattr as $intestArr)
           @php
                   $tiloop_count_prev=$tiloop_count_num;    
           @endphp   
         
     <div class="row shadow p-2" id="intest_attr_{{$tiloop_count_num++}}">              
         <div class="col-md-9 p-2">
            <input id="intestid" name="intestid[]" type="hidden" value="{{ $intestArr['id'] }}">
              <select name="test_id[]" id="test_id" class="form-control js-example-disabled-results me-3" >
              <option value="">Select Test </option>
                    @foreach($test as $list)
                        @if($intestArr['test_id'] ==$list->id)
                           <option  value="{{$list->id}}" selected> 
                               {{$list->test_name}} </option>
                                  @else
                           <option  value="{{$list->id}}" > 
                                {{$list->test_name}} </option>
                          @endif
                       @endforeach
                                              
             </select>
        </div>
     
        <div class="col-md-3 p-2"> 
           @if($tiloop_count_num==2)
                  <button type="button" onClick="tiadd_more()" class="btn btn-primary">
                <i class="fa fa-plus"></i> </button>  
           @else
                    <a class="btn btn-danger" 
                      onclick="return confirm('Are you sure you want to Delete this Item')" href="{{url('doctor/intest/delete/')}}/{{$intestArr['id']}}" role="button"><i class="fa fa-minus"></i></a>                                     
           @endif  
        </div>

      </div>
        @endforeach

      </div>

   
     </div>

  </div>

 <!-- Test In END -->




  <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div>

         <div class="mt-4">
             <button type="submit" id="edit_appointment_btn" class="btn btn-success">Update </button>
          </div>
            
    </div>
  
    </form>
 


</div>

<script src="{{ asset('js/appointment_setup.js') }}"></script>
<script type="text/javascript">
  
    $(".js-example-disabled-results").select2();
    $('.js-example-basic-multiple').select2();

  
  </script>


@endsection



