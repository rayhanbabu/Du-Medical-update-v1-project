@extends('layouts/dashboardheader')
@section('page_title','Diagnostic Dashboard')
@section('test_manage','active')
@section('content')
 
 
<div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
      <div class="row">
        <div class="col-8">
            <h4> Nursing Report </h4> 
       </div>
       <div class="col-2">
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
       

         </div>
      </div>


      <div class="col-2">
        <div class="d-grid gap-2 d-md-flex ">
                 <a class="btn btn-info btn-sm" href="{{url('nursing/nursing_list')}}" role="button"> Back </a>
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
      
      <div class="row g-1">
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
                         Appointment Id: <b>{{$appointment->id}}</b><br>
                         Reg / Employee Id: <b> {{$appointment->registration}} </b><br> 
                         Referred By : <b>{{$appointment->name}}</b><br>   
                         Service : <b>{{$appointment->nursing_service}}</b><br>  
                         Comment : <b>{{$appointment->nursing_comment}}</b><br>  
                     </div>

                     <div class="col-md-4">
                          Age:<b> {{$appointment->age}} </b><br>
                          Gender:<b> {{$appointment->gender}} </b><br>
                
                     @if($appointment->nursing_status==1)
                       <a href="{{ url('nursing/status/active/'.$appointment->id) }}" 
                        onclick="return confirm('Are you sure you want to change this status?')" 
                        class="btn btn-success btn-sm">Completed</a>
                     @else
                       <a href="{{ url('nursing/status/inactive/'.$appointment->id) }}" 
                        onclick="return confirm('Are you sure you want to change this status?')" 
                        class="btn btn-danger btn-sm">Pending</a>
                     @endif
                   

      
             
                     </div>
              </div>

              <br>
          </div>
      </div>


     <!-- Nursing Start -->
   <div class="col-md-7 mt-2 p-1">
         <div class="shadow p-2">
               <div class="d-grid gap-2 d-md-flex justify-content-md-end">    
                         <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add</button>      
                </div>
            <hr>

    
          
    <div class="row">
     <div class="col-md-12">

     <div class="table-responsive">
            <table class="table  table-bordered data-table">
                 <thead>
                     <tr>
                          <td> Service Type </td>
                          <td> Nurses Name  </td>
                          <td> Comment  </td>
                          <td> Time  </td>
                          <td> Delete  </td>
                      </tr>
                   </thead>
                   <tbody>

                   </tbody>

                </table>
          </div>

                    </div> 
              </div>
          </div>
      </div>
       <!-- Nursing END -->

    </div>
    

   </div>

   <script src="{{ asset('js/nursing_setup.js') }}"></script>


     <script type="text/javascript">

           fetchAll();
    function fetchAll() {
        // Destroy existing DataTable if it exists
        if ($.fn.DataTable.isDataTable('.data-table')) {
            $('.data-table').DataTable().destroy();
        }

        // Initialize DataTable
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "/nursing/nursing_service/{{$appointment->id}}",
                error: function(xhr, error, code) {
                    console.log(xhr.responseText);
                }
            },
            columns: [
                { data: 'service_type', name: 'service_type' },
                { data: 'name', name: 'name' },
                { data: 'comment', name: 'comment' },
                { data: 'created_at', name: 'created_at' },
                { data: 'delete', name: 'delete', orderable: false, searchable: false }
            ]
        });
    }


            
       </script>



{{-- add new Student modal start --}}
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form  method="POST" id="add_employee_form" enctype="multipart/form-data">

        <div class="modal-body p-4 bg-light">
          <div class="row">

            <input type="hidden" name="appointment_id" value="{{$appointment->id}}" class="form-control"> 
            <input type="hidden" name="member_id" value="{{$appointment->member_id}}" class="form-control"> 
            
             <div class="col-lg-6 ">
                   <label class=""> Service Type <span style="color:red;"> * </span> </label>
                   <input type="text" name="service_type" id="service_type" class="form-control" value="{{$appointment->nursing_service}}" readonly >
                  
             </div>

            <div class="col-lg-6 ">
                 <label for="roll">Comment </label>
                 <input type="text" name="comment" id="comment" class="form-control" placeholder="" >
                 <p class="text-danger error_comment"></p>
            </div>


              <ul class="alert alert-warning d-none" id="add_errorlist"></ul>
          </div>    


          <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div>

        <div class="mt-4">
          <button type="submit" id="add_employee_btn" class="btn btn-primary">Submit </button>
       </div>  

      </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
       
        </div>
      </form>
    </div>
  </div>
</div>

{{-- add new employee modal end --}}


@endsection



