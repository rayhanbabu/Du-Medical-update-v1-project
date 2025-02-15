@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('test_list','active')
@section('content')
 
 <div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
      <div class="row">
        <div class="col-4">
            <h4> Daignostic Add </h4> 
       </div>
     
   
       <div class="col-4">
       <form method="POST" id="search_form" enctype="multipart/form-data">
          <div class="d-grid gap-2 d-md-flex ">
      
             <input type="text" name="search_name" class="form-control form-control-sm" required placeholder="Search By Appointment Id " >
             <button type="submit" id="search_button"  class="btn btn-success btn-sm "> Search </button>
           
          </div>
        </form>
      </div>
     
     

      <div class="col-4">
      <div class="d-grid gap-2 d-md-flex justify-content-center">
          
            <a class="btn btn-primary btn-sm" href="{{url('/diagnostic/test_list')}}" role="button"> Back </a>
          
        </div>
      </div>


     <div class="text-center">
        <p class="text-danger error_search"> </p>
    </div>
      

    </div>


    @if(Session::has('fail'))
    <div class="alert alert-danger"> {{Session::get('fail')}}</div>
    @endif

    @if(Session::has('success'))
    <div class="alert alert-success"> {{Session::get('success')}}</div>
    @endif


  </div>

  @if($appointment_id)
  <form method="POST" id="diagnostic_setup_form" enctype="multipart/form-data">
     <div class="card-body">
   
    <div class="row g-1">
       
       <div class="col-md-5 mt-2 p-1">
         <div class="shadow p-2">
              <b> Patient Information </b>
              <hr>
              <div class="row">
                    <div class="col-md-8">
                        @if($appointment->careof)
                            Member Name : <b> {{$appointment->member->member_name}} </b> <br>
                            Careof & Patient : <b> {{$appointment->careof->family_member_name}} </b> <br>
                        @else
                          Patient Name : <b> {{$appointment->member->member_name}} </b> <br>
                        @endif
                        Appointment Id: <b>  {{$appointment->id}}</b> <br>
                        Appintment Date: <b> {{$appointment->date}} </b><br>
                     </div>

                    
              </div>

              <br>
          </div>
      </div>


   

  

  <!-- Test In Start -->
 <div class="col-md-5 mt-2 p-1">
      <div class="shadow p-3">
          <b> Test Selcet </b>
       <hr>
       <input type="hidden" name="appointment_id" value="{{$appointment->id}}" class="form-control" >
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
                      onclick="return confirm('Are you sure you want to Delete this Item')" href="{{url('diagnostic/intest/delete/')}}/{{$intestArr['id']}}" role="button"><i class="fa fa-minus"></i></a>                                     
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
             <button type="submit" id="diagonostic_btn" class="btn btn-success"> Save & Update </button>
          </div>
            
    </div>
  
    </form>

    @endif
 


</div>

<script src="{{ asset('js/diagnostic_setup.js') }}"></script>
<script type="text/javascript">
  
    $(".js-example-disabled-results").select2();
    $('.js-example-basic-multiple').select2();

  
  </script>


@endsection



