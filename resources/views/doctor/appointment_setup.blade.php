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
         <input type="hidden" name="appointment_id" value="{{$appointment->id}}" class="form-control" >
         <input type="hidden" name="member_id" value="{{$appointment->member_id}}" class="form-control" >
         <input type="hidden" name="member_category" value="{{$appointment->member_category}}" class="form-control" >
       <div class="col-md-5 mt-2 p-1">
         <div class="shadow p-2">
              <b> Patient Information </b>
              <hr>
              <div class="row">
                    <div class="col-md-8">
                    @if($appointment->family_member_name)
                       Name:<b>{{$appointment->member_name}}</b><br>
                       Care of & Patient :<b>{{$appointment->family_member_name}}</b><br>
                     @else
                         Patient Name:<b>{{$appointment->member_name}}</b><br>
                      
                     @endif
                       Appointment Id:<b>{{$appointment->id}}</b><br>
                       Reg/ Employee Id: <b> {{$appointment->registration}} </b><br>
                       Problem Description:<b>  {{$appointment->disease_problem}} </b>
                     </div>

                     <div class="col-md-4">
                         Age:<b> {{$appointment->age}} Year</b><br>
                         Gender:<b> {{$appointment->gender}}</b><br>
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
                        <option value="Dressing" {{ $appointment->nursing_service == 'Dressing' ? 'selected' : '' }}>Dressing</option>
                        <option value="Injection" {{ $appointment->nursing_service == 'Injection' ? 'selected' : '' }}>Injection</option>
                        <option value="Nebulizer" {{ $appointment->nursing_service == 'Nebulizer' ? 'selected' : '' }}>Nebulizer</option>
                        <option value="Blood_Suger" {{ $appointment->nursing_service == 'Blood_Suger' ? 'selected' : '' }}>Blood_Suger</option>
                        <option value="Others" {{ $appointment->nursing_service == 'Others' ? 'selected' : '' }}>Others</option>
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
                     
                      <div class="form-check">
                      <input class="form-check-input" name="indoor_service" type="checkbox" value="Eligible" id="flexCheckDefault"
                           {{ $appointment->indoor_service == 'Eligible' ? 'checked' : '' }}>
                       <label class="form-check-label" for="flexCheckDefault">
                           Admission is eligible
                      </label>
                       </div>

                        <div class="form-group p-2">
                              <label class=""> Comment(If Any) </label>
                              <input type="text" id="indoor_comment" value="{{$appointment->indoor_comment}}" name="indoor_comment" class="form-control form-control-sm" >
                        </div> 

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
                        <textarea id="advise" name="advise" placeholder="Advise" class="form-control form-control-sm" rows="4" >{{ $appointment->advise }}</textarea>
                         </div>
                    </div> 
              </div>
          </div>
      </div>
       <!-- Isolation  END -->

      <!-- Medicine In Start -->
   <div class="col-md-3 mt-2 p-1">
      <div class="shadow p-3">
          <b> Medicine in Pharmacy </b>
       <hr>

     <div class="" id="inmedicine_attr_box">
                    @php
                          $loop_count_num=1;
                   @endphp
     
          @foreach($inmedicineattr as $inmedicineArr)
          @php
                   $loop_count_prev=$loop_count_num;    
          @endphp   
         
     <div class="row shadow p-2" id="inmedicine_attr_{{$loop_count_num++}}">              
         <div class="col-md-8 p-2">
            <input id="inmedicineid" name="inmedicineid[]" type="hidden" value="{{ $inmedicineArr['id'] }}">
            <select name="generic_id[]" id="generic_id" class="form-control js-example-disabled-results me-3" >
              <option value="">Select Medicine </option>
                    @foreach($generic as $list)
                        @if($inmedicineArr['generic_id'] ==$list->id)
                           <option  value="{{$list->id}}" selected> 
                               {{$list->generic_name}} </option>
                                  @else
                           <option  value="{{$list->id}}" > 
                                {{$list->generic_name}} </option>
                          @endif
                       @endforeach
                                              
             </select>
        </div>
       <div class="col-md-4 p-2">
            <input type="text" id="total_piece" name="total_piece[]" value="{{$inmedicineArr['total_piece']}}" placeholder="Quantity" class="form-control form-control-sm" >
       </div>


       <div class="col-md-5 p-2">
    <select name="eating_time[]" id="eating_time" class="form-control form-control-sm">
        <option value="B-L-D" {{ $inmedicineArr['eating_time'] == 'B-L-D' ? 'selected' : '' }}>B-L-D</option>
        <option value="B-0-D" {{ $inmedicineArr['eating_time'] == 'B-0-D' ? 'selected' : '' }}>B-0-D</option>
        <option value="B-0-0" {{ $inmedicineArr['eating_time'] == 'B-0-0' ? 'selected' : '' }}>B-0-0</option>
        <option value="0-0-D" {{ $inmedicineArr['eating_time'] == '0-0-D' ? 'selected' : '' }}>0-0-D</option>
        <option value="0-L-0" {{ $inmedicineArr['eating_time'] == '0-L-0' ? 'selected' : '' }}>0-L-0</option>
    </select>
</div>


<div class="col-md-5 p-2">
    <select name="eating_status[]" id="eating_status" class="form-control form-control-sm me-3">
        <option value="After Meal" {{ $inmedicineArr['eating_status'] == 'After Meal' ? 'selected' : '' }}>After Meal</option>
        <option value="Before Meal" {{ $inmedicineArr['eating_status'] == 'Before Meal' ? 'selected' : '' }}>Before Meal</option>
    </select>
</div>

        <div class="col-md-2 p-2"> 
           @if($loop_count_num==2)
                  <button type="button" onClick="add_more()" class="btn btn-primary">
                <i class="fa fa-plus"></i> </button>  
           @else
                    <a class="btn btn-danger" 
                      onclick="return confirm('Are you sure you want to Delete this Item')" href="{{url('doctor/inmedicine/delete/')}}/{{$inmedicineArr['id']}}" role="button"><i class="fa fa-minus"></i></a>                                     
           @endif  
        </div>

      </div>
        @endforeach

      </div>

   
     </div>

  </div>

 <!-- Medicine In END -->


 <!-- Medicine Outsite Start -->
 <div class="col-md-3 mt-2 p-1">
      <div class="shadow p-3">
          <b> Medicine Out of Pharmacy </b>
       <hr>

     <div class="" id="outmedicine_attr_box">
                    @php
                          $moloop_count_num=1;
                         $moloop_count_prev=$moloop_count_num;
                   @endphp
     
          @foreach($outmedicineattr as $outmedicineArr)
          @php
                   $moloop_count_prev=$moloop_count_num;    
          @endphp   
         
     <div class="row shadow p-2" id="outmedicine_attr_{{$moloop_count_num++}}">              
         <div class="col-md-8 p-2">
            <input id="outmedicineid" name="outmedicineid[]" type="hidden" value="{{ $outmedicineArr['id'] }}">
            <input type="text" id="medicine_name" name="medicine_name[]" value="{{$outmedicineArr['medicine_name']}}" placeholder="Medicine name" class="form-control form-control-sm" >
        </div>
       <div class="col-md-4 p-2">
            <input type="text" id="total_day" name="total_day[]" value="{{$outmedicineArr['total_day']}}" placeholder="Day" class="form-control form-control-sm" >
       </div>


       <div class="col-md-5 p-2">
    <select name="outeating_time[]" id="outeating_time" class="form-control form-control-sm">
        <option value="B-L-D" {{ $outmedicineArr['eating_time'] == 'B-L-D' ? 'selected' : '' }}>B-L-D</option>
        <option value="B-0-D" {{ $outmedicineArr['eating_time'] == 'B-0-D' ? 'selected' : '' }}>B-0-D</option>
        <option value="B-0-0" {{ $outmedicineArr['eating_time'] == 'B-0-0' ? 'selected' : '' }}>B-0-0</option>
        <option value="0-0-D" {{ $outmedicineArr['eating_time'] == '0-0-D' ? 'selected' : '' }}>0-0-D</option>
        <option value="0-L-0" {{ $outmedicineArr['eating_time'] == '0-L-0' ? 'selected' : '' }}>0-L-0</option>
    </select>
</div>


<div class="col-md-5 p-2">
    <select name="outeating_status[]" id="outeating_status" class="form-control form-control-sm me-3">
        <option value="After Meal" {{ $outmedicineArr['eating_status'] == 'After Meal' ? 'selected' : '' }}>After Meal</option>
        <option value="Before Meal" {{ $outmedicineArr['eating_status'] == 'Before Meal' ? 'selected' : '' }}>Before Meal</option>
    </select>
</div>

        <div class="col-md-2 p-2"> 
           @if($moloop_count_num==2)
                  <button type="button" onClick="moadd_more()" class="btn btn-primary">
                <i class="fa fa-plus"></i> </button>  
           @else
                    <a class="btn btn-danger" 
                      onclick="return confirm('Are you sure you want to Delete this Item')" href="{{url('doctor/outmedicine/delete/')}}/{{$outmedicineArr['id']}}" role="button"><i class="fa fa-minus"></i></a>                                     
           @endif  
        </div>

      </div>
        @endforeach

      </div>

   
     </div>

  </div>

  <!-- Medicine Outsite END -->



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


 <!-- Test Outside Start -->
<div class="col-md-3 mt-2 p-1">
      <div class="shadow p-3">
          <b> Test out of Medical </b>
       <hr>

     <div class="" id="outtest_attr_box">
                    @php
                          $toloop_count_num=1;
                         $toloop_count_prev=$toloop_count_num;
                   @endphp
     
          @foreach($outtestattr as $outtestArr)
           @php
                   $toloop_count_prev=$toloop_count_num;    
           @endphp   
         
     <div class="row shadow p-2" id="outtest_attr_{{$toloop_count_num++}}">              
         <div class="col-md-9 p-2">
            <input id="outtestid" name="outtestid[]" type="hidden" value="{{ $outtestArr['id'] }}">
            <input type="text" id="test_name" name="test_name[]" value="{{$outtestArr['test_name']}}" placeholder="Test name" class="form-control form-control-sm" >
        </div>
     
        <div class="col-md-3 p-2"> 
            @if($toloop_count_num==2)
                  <button type="button" onClick="toadd_more()" class="btn btn-primary">
                <i class="fa fa-plus"></i> </button>  
            @else
                    <a class="btn btn-danger" 
                      onclick="return confirm('Are you sure you want to Delete this Item')" href="{{url('doctor/outtest/delete/')}}/{{$outtestArr['id']}}" role="button"><i class="fa fa-minus"></i></a>                                     
            @endif  
        </div>

      </div>
        @endforeach

      </div>

   
     </div>

  </div>

 <!-- Test Outside END -->




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



