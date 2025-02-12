@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('diagnostic','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
       <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> {{ $user->userType }}  Schedule  Edit  </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    

                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                           <a class="btn btn-primary btn-sm" href="{{url('admin/staffduty/'.$user->userType)}}" role="button"> Back </a>
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
  <form method="post" action="{{url('admin/staffduty/insert')}}"  class="myform"  enctype="multipart/form-data" >
     {!! csrf_field() !!}

     <input type="hidden" name="user_id"  value="{{$user->id}}" class="form-control">
     <input type="hidden" name="userType"  value="{{$user->userType}}" class="form-control">

     <div class="row px-2">

     <table class="table">
    <tbody>
          @foreach($data_list as $row)
           <tr>
             <td> {{$row->week_name}} </td>
             @if($table=="staffduties")
               <td> <input type="test" name="duty_time[]" value="{{$row->duty_time}}" class="form-control" > </td>
             @else 
              <td> <input type="test" name="duty_time[]" value="" class="form-control" > </td>
             @endif   
               <td>
                   <input type="hidden" name="week_name[]"  value="{{$row->week_name}}" class="form-control">
               </td>
            </tr>
          @endforeach
          
  </tbody>
</table>
        

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