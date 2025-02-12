@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('appointment','active')
@section('content')




 <div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
      <div class="row">
        <div class="col-8">
           <h5 class="mt-0">  Make an Appointment     </h5>
      </div>
      <div class="col-2">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
       

        </div>
      </div>


      <div class="col-2">
        <div class="d-grid gap-2 d-md-flex ">
         
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
  <div class="card-body">
    <div class="row">
      <div class="col-md-4 mt-2 p-3 shadow">

          <div class="row">
               <div class="col-4">
                   Member Seach   
                </div>
                <div class="col-4">
                   <button type="submit"  class="btn btn-success btn-sm "> ICT Cell </button>
                </div>
                 <div class="col-4">
                     <button type="submit"  class="btn btn-success btn-sm "> Manual </button>
                  </div>

            </div>
         <hr>
      <form method="POST" id="search_form" enctype="multipart/form-data">
       <div class="form-group p-2">
               <input type="text" name="search_name" class="form-control form-control-sm" required placeholder="Search By DU Registration/Employee ID/Phone " >
               <p class="text-danger error_registration"></p>
              </div> 
       <div class="form-group p-2">
           <button type="submit" id="search_button"  class="btn btn-success btn-sm "> Search </button>
       </div>
      </form>

      
      
 
    
       
    </div>

   <div class="col-md-8 mt-2 p-3 shadow">

      @if($member_id)
    <form method="POST" id="appointment_form" enctype="multipart/form-data">
    <input type="hidden" id="member_id" name="member_id" value="{{$member->id}}" class="form-control form-control-sm" required>
     <div class="row">
     <div class="col-sm-6">
          <div class="form-group p-2">
               <label class=""> Member Name </label><br>
                  <b>{{$member->member_name}} </b>
           </div> 
      </div>

      <div class="col-sm-6">
          <div class="form-group p-2">

                <label class=""><b> Describe Disease Problem   <span style="color:red;"> * </span></b></label><br>
                <input type="text" id="disease_problem" name="disease_problem" class="form-control form-control-sm" required>
           </div> 
      </div>


      <div class="col-sm-6">
          <div class="form-group p-2">
               <label class=""> DU Registration/ Employee ID  </label><br>
                 <b>{{$member->registration}} </b>
                
           </div> 
      </div>


      <div class="col-sm-6">
          <div class="form-group p-2">
               <label class=""><b> Service Name  <span style="color:red;"> * </span></b></label><br>
                 <select name="service_name" id="service_name"  class="form-control js-example-disabled-results" style="max-width:360px;" required>
                  <option value="">Select Service </option>
                      @foreach($service as $row)
                        <option value="{{ $row->service_name }}">
                           {{ $row->service_name }}
                        </option>
                      @endforeach
                 </select>
           </div> 
      </div>


      <div class="col-sm-6">
      <div class="form-group p-2">
               <label class=""><b> Patient Name </b></label><br>
                 <select name="careof_id" id="careof_id"  class="form-control js-example-disabled-results" style="max-width:350px;" required>
                    <option value="MySelf"> MySelf </option>
                    @foreach($family as $row)
                     <option value="{{ $row->id }}">
                        {{ $row->family_member_name }}
                      </option>
                    @endforeach
                 
                 </select>
           </div> 
      </div>


      <div class="col-sm-6">
          <div class="form-group p-2">
                <label class=""><b> Room No  <span style="color:red;"> * </span></b></label><br>
                <input type="text" id="room" name="room" class="form-control form-control-sm" required>
           </div> 
      </div>


         <div class="loader">
                <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div>

         <div class="form-group p-4">
              <button type="submit"  id="appointment_button" class="btn btn-success btn-sm "> Confirm Appointment</button>
         </div>


         <p class="text-success appointment_print"></p>


      </div>
     </form> 
      @endif

    </div>
       </div>


  </div>
</div>



 <script src="{{ asset('js/appointment.js') }}"></script>
 <script type="text/javascript">

  $(".js-example-disabled-results").select2();



</script>


@endsection