@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('medicine_list','active')
@section('content')
 
 <div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
      <div class="row">
        <div class="col-4">
            <h4> Pharmacy Add </h4> 
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
          
            <a class="btn btn-primary btn-sm" href="{{url('/pharmacy/medicine_list')}}" role="button"> Back </a>
          
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
  <form method="POST" id="pharmacy_setup_form" enctype="multipart/form-data">
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


   

  

 <!-- Medicine In Start -->
 <div class="col-md-6 mt-2 p-1">
      <div class="shadow p-3">
      
       <hr>

       <input type="hidden" id="appointment_id" name="appointment_id" value="{{$appointment->id}}" required>
    
       <div class="" id="inmedicine_attr_box">
                    @php
                          $loop_count_num=1;
                   @endphp
     
        
          @php
                   $loop_count_prev=$loop_count_num;    
          @endphp   
         
     <div class="row shadow p-2" id="inmedicine_attr_{{$loop_count_num++}}">              
         <div class="col-md-7 p-2">
               <select name="generic_id[]" id="generic_id" class="form-control js-example-disabled-results me-3" >
                          <option value=""> Select Product </option>
                            @foreach($generic as $list)
                               <option  value="{{$list->generic_id}}" > 
                                 {{$list->generic->generic_name}}, Available({{ $list->available_unit }} Unit) </option>
                             @endforeach                                            
               </select>
        </div>
       <div class="col-md-3 p-2">
            <input type="text" id="total_piece" name="total_piece[]" value=""  placeholder="Quantity" class="form-control form-control-sm" >
       </div>


      




        <div class="col-md-2 p-2"> 
           @if($loop_count_num==2)
                  <button type="button" onClick="add_more()" class="btn btn-primary">
                <i class="fa fa-plus"></i> </button>  
           @else
                  
           @endif  
        </div>

      </div>
     

      </div>

   
     </div>

  </div>

 <!-- Medicine In END -->



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

<script src="{{ asset('js/medicine_list.js') }}"></script>
<script type="text/javascript">
  
    $(".js-example-disabled-results").select2();
    $('.js-example-basic-multiple').select2();

  
  </script>


@endsection



