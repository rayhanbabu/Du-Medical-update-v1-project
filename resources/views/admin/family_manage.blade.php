@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('diagnostic','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
       <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> {{$member->member_name}} Family @if(!$id) Add @else Edit @endif </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                           <a class="btn btn-primary btn-sm" href="{{url('admin/family/'.$member->id)}}" role="button"> Back </a>
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
  <form method="post" action="{{url('admin/family/insert')}}"  class="myform"  enctype="multipart/form-data" >
  {!! csrf_field() !!}

     <input type="hidden" name="id"  value="{{$id}}" class="form-control" >
     <input type="hidden" name="member_id"  value="{{$member->id}}" class="form-control" >

     <div class="row px-2">

        
           <div class="form-group col-sm-3  my-2">
                <label class=""><b>Relation Type  <span style="color:red;"> * </span> </b></label>
                 <select class="form-select form-select-sm" name="relation_type"  aria-label="Default select example">
                      <option value="Father" {{ $relation_type == 'Father' ? 'selected' : '' }}> Father </option>
                      <option value="Mother" {{ $relation_type == 'Mother' ? 'selected' : '' }}> Mother </option>
                      <option value="Spouse" {{ $relation_type == 'Spouse' ? 'selected' : '' }}> Spouse </option>
                      <option value="Child" {{ $relation_type == 'Child' ? 'selected' : '' }}> Child </option>
                </select>
           </div> 

           <div class="form-group col-sm-3 my-2">
               <label class=""><b>Family Member Name  <span style="color:red;"> * </span></b></label>
               <input type="text" name="family_member_name" class="form-control form-control-sm" value="{{$family_member_name}}" required>
          </div> 
            

           <div class="form-group col-sm-3 my-2">
                   <label class=""> Gender  <span style="color:red;"> * </span> </label>
                     <select class="form-control" name="gender" aria-label="Default select example">
                         <option value="Male" {{ $gender == 'Male' ? 'selected' : '' }}>Male</option>
                         <option value="Female" {{ $gender == 'Female' ? 'selected' : '' }}>Female</option>
                         <option value="Other" {{ $gender == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
            </div> 

          <div class="form-group col-sm-3 my-2">
                <label for="roll"> Date of Birth  <span style="color:red;"> * </span>  </label>
                <input type="date" name="dobirth"  value="{{$dobirth}}" class="form-control" placeholder="" required>
          </div> 
            

          
            
            <div class="form-group col-sm-3  my-2">
                <label class=""><b> Status <span style="color:red;"> * </span> </b></label>
                 <select class="form-select form-select-sm" name="status"  aria-label="Default select example">
                      <option value="1" {{ $status == '1' ? 'selected' : '' }}> Active </option>
                      <option value="0" {{ $status == '0' ? 'selected' : '' }}> Inactive </option>
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