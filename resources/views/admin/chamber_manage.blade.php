@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('chamber','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
       <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> Chamber @if(!$id) Add @else Edit @endif </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                           <a class="btn btn-primary btn-sm" href="{{url('admin/chamber')}}" role="button"> Back </a>
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
  <form method="post" action="{{url('admin/chamber/insert')}}"  class="myform"  enctype="multipart/form-data" >
  {!! csrf_field() !!}

     <input type="hidden" name="id"  value="{{$id}}" class="form-control" >

     <div class="row px-2">

          <div class="form-group col-sm-3 my-2">
               <label class=""><b>Chamber Name <span style="color:red;"> * </span></b></label>
               <input type="text" name="chamber_name" class="form-control form-control-sm" value="{{$chamber_name}}" required>
          </div> 

          <div class="form-group col-sm-3 my-2">
               <label class=""><b> Doctor  <span style="color:red;"> * </span></b></label><br>
                 <select name="user_id" id="user_id"  class="form-control js-example-disabled-results" style="max-width:300px;" required>
                  <option value="">Select Doctor </option>
                   @foreach($user as $row)
                      <option value="{{ $row->id }}" {{ $row->id == $user_id ? 'selected' : '' }}>
                          {{ $row->name }}
                      </option>
                   @endforeach
                 </select>
           </div> 

           <div class="form-group col-sm-3 my-2">
               <label class=""><b> Service  <span style="color:red;"> * </span></b></label><br>
                 <select name="service_name" id="service_name"  class="form-control js-example-disabled-results" style="max-width:300px;" required>
                  <option value="">Select Service </option>
                   @foreach($service as $row)
                      <option value="{{ $row->service_name }}" {{ $row->service_name == $service_name ? 'selected' : '' }}>
                          {{ $row->service_name }}
                      </option>
                   @endforeach
                 </select>
           </div> 

           <div class="form-group col-sm-3  my-2">
                <label class=""><b> Chamber Type <span style="color:red;"> * </span> </b></label>
                  <select class="form-select form-select-sm" name="chamber_type"  aria-label="Default select example">
                     <option value="Both" {{ $chamber_type == 'Both' ? 'selected' : '' }}> Both </option>
                     <option value="Male" {{ $chamber_type == 'Male' ? 'selected' : '' }}> Male </option>
                     <option value="Female" {{ $chamber_type == 'Female' ? 'selected' : '' }}> Female </option>
                 </select>
           </div> 


           <div class="form-group col-sm-3  my-2">
                <label class=""><b>Chamber Status <span style="color:red;"> * </span> </b></label>
                 <select class="form-select form-select-sm" name="chamber_status"  aria-label="Default select example">
                      <option value="1" {{ $chamber_status == '1' ? 'selected' : '' }}> Active </option>
                      <option value="0" {{ $chamber_status == '0' ? 'selected' : '' }}> Inactive </option>
                </select>
           </div> 

          <div class="form-group col-sm-3 my-2">
               <label class=""><b>Room <span style="color:red;"> * </span></b></label>
               <input type="text" name="room" class="form-control form-control-sm" value="{{$room}}" required>
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