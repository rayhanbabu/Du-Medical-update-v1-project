@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('ward_list','active')
@section('content')
 
 <div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
      <div class="row">
        <div class="col-4">
            <h4> Isolation Ward Service </h4> 
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
          
            <a class="btn btn-primary btn-sm" href="{{url('/ward/ward_list')}}" role="button"> Back </a>
          
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

     <div class="card-body">
   
    <div class="row g-1">
       
       <div class="col-md-4 mt-2 p-1">
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
 <div class="col-md-8 mt-2 p-1">
     
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
                          <td> Disease </td>
                          <td> Admited Time  </td>
                          <td> Comment  </td>
                          <td> Ward No  </td>
                          <td> Bed No  </td>
                          <td> Released Time  </td>
                          <td> Stay Hour  </td>
                          <td> Edit  </td>
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

  </div>

 <!-- Test In END -->
          
    </div>
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
                url: "/ward/ward_service/{{$appointment->id}}",
                error: function(xhr, error, code) {
                    console.log(xhr.responseText);
                }
            },
            columns: [
                 { data: 'disease', name: 'disease' },
                 { data: 'admited_at', name: 'admited_at' },
                 { data: 'comment', name: 'comment' },
                 { data: 'ward_no', name: 'ward_no' },
                 { data: 'bed_no', name: 'bed_no' },
                 { data: 'released_at', name: 'released_at' },
                 { data: 'stay_hour', name: 'stay_hour' },
                 { data: 'edit', name: 'edit', orderable: false, searchable: false },
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
            
            

             <div class="col-lg-6">
                   <label class=""> Disease <span style="color:red;"> * </span> </label>
                   <input type="text" name="disease" id="disease" class="form-control" placeholder="" required>
             </div>

             <div class="col-lg-6">
                   <label class=""> Ward No <span style="color:red;"> * </span> </label>
                   <input type="text" name="ward_no" id="ward_no" class="form-control" placeholder="" required>
             </div>

             <div class="col-lg-6">
                   <label class=""> Bed No <span style="color:red;"> * </span> </label>
                   <input type="text" name="bed_no" id="bed_no" class="form-control" placeholder="" required>
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



{{-- edit employee modal start --}}
<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" id="edit_employee_form" enctype="multipart/form-data">
        <input type="hidden" name="edit_id" id="edit_id">
        <div class="modal-body p-4 bg-light">
          <div class="row">

         

             <div class="col-lg-6">
                   <label class=""> Disease <span style="color:red;"> * </span> </label>
                   <input type="text" name="disease" id="edit_disease" class="form-control" placeholder="" required>
             </div>

             <div class="col-lg-6">
                   <label class=""> Ward No <span style="color:red;"> * </span> </label>
                   <input type="text" name="ward_no" id="edit_ward_no" class="form-control" placeholder="" required>
             </div>

             <div class="col-lg-6">
                   <label class=""> Bed No <span style="color:red;"> * </span> </label>
                   <input type="text" name="bed_no" id="edit_bed_no" class="form-control" placeholder="" required>
             </div>

            <div class="col-lg-6 ">
                 <label for="roll">Comment </label>
                 <input type="text" name="comment" id="edit_comment" class="form-control" placeholder="" >
                 <p class="text-danger error_comment"></p>
            </div>


            <div class="col-lg-6 ">
                   <label class="">Isolation Release Status  <span style="color:red;"> * </span> </label>
                   <select class="form-select" name="isolation_status" id="edit_isolation_status" aria-label="Default select example">
                           <option value="No">No</option>  
                           <option value="Yes">Yes</option>                     
                   </select>
             </div>


          </div>



          <div class="mt-2" id="avatar"> </div>

          <div class="loader">
            <img src="{{ asset('images/abc.gif') }}" alt="" style="width: 50px;height:50px;">
          </div>

          <div class="mt-4">
            <button type="submit" id="edit_employee_btn" class="btn btn-success">Update </button>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit employee modal end --}}



    @endif
 


</div>

<script src="{{ asset('js/ward_setup.js') }}"></script>



@endsection



