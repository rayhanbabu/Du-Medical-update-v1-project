@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('diagnostic','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
       <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> Slot Allocation @if(!$id) Add @else Edit @endif </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                           <a class="btn btn-primary btn-sm" href="{{url('admin/slot/'.$chamber_id.'?week_name='.$week_name)}}" role="button"> Back </a>
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
  <form method="post" action="{{url('admin/slot/insert')}}"  class="myform"  enctype="multipart/form-data" >
  {!! csrf_field() !!}

     <input type="hidden" name="id"  value="{{$id}}" class="form-control" >

     <input type="hidden" name="chamber_id"  value="{{$chamber_id}}" class="form-control" >
     <input type="hidden" name="week_name"  value="{{$week_name}}" class="form-control" >

     <div class="row px-2">
         <div class="form-group col-sm-2 my-2">
               <label class=""><b>Serial(Slot Order) <span style="color:red;"> * </span></b></label>
               <input type="number" name="serial" class="form-control form-control-sm" value="{{$serial}}" required>
          </div> 

          <div class="form-group col-sm-3 my-2">
               <label class=""><b>Slot Time <span style="color:red;"> * </span></b></label>
               <input type="text" name="slot_time" class="form-control form-control-sm" value="{{$slot_time}}" required>
          </div> 

          <div class="form-group col-sm-3  my-2">
                <label class=""><b>Duty Type <span style="color:red;"> * </span> </b></label>
                  <select class="form-select form-select-sm" name="duty_type"  aria-label="Default select example">
                       <option value="Morning" {{ $duty_type == 'Morning' ? 'selected' : '' }}> Morning </option>
                       <option value="Evening" {{ $duty_type == 'Evening' ? 'selected' : '' }}> Evening </option>
                       <option value="Night" {{ $duty_type == 'Night' ? 'selected' : '' }}> Night </option>                     
                 </select>
           </div> 

          <div class="form-group col-sm-3 my-2">
               <label class=""><b>Booking Last Time(24 hour) <span style="color:red;"> * </span></b></label>
               <input type="text" name="booking_last_time" class="form-control form-control-sm" 
                    value="{{ $booking_last_time }}" required 
                    pattern="^\d+(\.\d{1,2})?$" 
                     title="Please enter a valid number with up to 2 decimal places">
             </div> 

          <div class="form-group col-sm-2  my-2">
                <label class=""><b> Slot Type <span style="color:red;"> * </span> </b></label>
                 <select class="form-select form-select-sm" name="slot_type"  aria-label="Default select example">
                      <option value="Online" {{ $slot_type == 'Online' ? 'selected' : '' }}> Online </option>
                      <option value="Offline" {{ $slot_type == 'Offline' ? 'selected' : '' }}> Offline </option>
                      <option value="Tea_brack" {{ $slot_type == 'Tea_brack' ? 'selected' : '' }}> Tea_brack </option>
                      <option value="Oncall" {{ $duty_type == 'Oncall' ? 'selected' : '' }}> Oncall </option>
                  </select>
           </div> 
            
            <div class="form-group col-sm-2  my-2">
                <label class=""><b>Slot Status <span style="color:red;"> * </span> </b></label>
                 <select class="form-select form-select-sm" name="slot_status"  aria-label="Default select example">
                      <option value="1" {{ $slot_status == '1' ? 'selected' : '' }}> Active </option>
                      <option value="0" {{ $slot_status == '0' ? 'selected' : '' }}> Inactive </option>
                </select>
           </div> 


       </div>
           <br>
        <input type="submit"   id="insert" value="Submit" class="btn btn-success" />
	  
              
     </div>

     </form>

  </div>
</div>



<script type="text/javascript">

$(".js-example-disabled-results").select2();



</script>




   


@endsection