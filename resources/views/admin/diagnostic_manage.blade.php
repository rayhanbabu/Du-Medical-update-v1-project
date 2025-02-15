@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('diagnostic','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
       <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> {{ $test->test_name }} Diagnostic @if(!$id) Add @else Edit @endif </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                           <a class="btn btn-primary btn-sm" href="{{url('admin/diagnostic/'.$test->id)}}" role="button"> Back </a>
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
  <form method="post" action="{{url('admin/diagnostic/insert')}}"  class="myform"  enctype="multipart/form-data" >
  {!! csrf_field() !!}

     <input type="hidden" name="id"  value="{{$id}}" class="form-control">
     <input type="hidden" name="test_id"  value="{{$test->id}}" class="form-control">

     <div class="row px-2">

    

          
          <div class="form-group col-sm-3 my-2">
               <label class=""><b>Diagnostic Name <span style="color:red;"> * </span></b></label>
               <input type="text" name="diagnostic_name" class="form-control form-control-sm" value="{{$diagnostic_name}}" required>
          </div> 

          <div class="form-group col-sm-3 my-2">
               <label class=""><b>Reference Range </b></label>
               <input type="text" name="reference_range" class="form-control form-control-sm" value="{{$reference_range}}" >
          </div> 

          <div class="form-group col-sm-3 my-2">
               <label class=""><b> Diagnostic Character </b></label><br>
                 <select name="character_id" id="character_id"  class="form-control js-example-disabled-results" style="max-width:300px;" >
                  <option value="">Select One </option>
                   @foreach($character as $row)
                      <option value="{{ $row->id }}" {{ $row->id == $character_id ? 'selected' : '' }}>
                          {{ $row->character_name }}
                      </option>
                   @endforeach
                 </select>
           </div> 
            
            <div class="form-group col-sm-3  my-2">
                <label class=""><b>Diagnostic Status <span style="color:red;"> * </span> </b></label>
                 <select class="form-select form-select-sm" name="diagnostic_status"  aria-label="Default select example">
                      <option value="1" {{ $diagnostic_status == '1' ? 'selected' : '' }}> Active </option>
                      <option value="0" {{ $diagnostic_status == '0' ? 'selected' : '' }}> Inactive </option>
                </select>
           </div> 

           <div class="form-group col-sm-3 my-2">
               <label class=""><b> By Default Value </b></label>
               <input type="text" name="default_value" class="form-control form-control-sm" value="{{$default_value}}" >
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