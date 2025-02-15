@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('ambulance','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
       <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> Ambulance Service </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    
                   <div class="col-2">
                       <div class="d-grid gap-2 d-md-flex ">
                            <button type="button" class="bazar_entry btn btn-success btn-sm">Add</button>
                       </div>
                     </div> 
         </div>
           
      </div>
  <div class="card-body">   


  <div class="bazar-entry-show" style="background-color:aliceblue; padding:10px;">
  <form method="post" id="add_form" enctype="multipart/form-data">
    <div class="row">

    <div class="col-sm-2">
        <label> Appointment Id</label>
        <input name="appointment_id" id="appointment_id" type="text" class="form-control form-control-sm" placeholder="" required />
      </div>

    <div class="col-sm-2">
        <label>Driver name</label><br>
        <select name="driver_id" id="driver_id" class="js-example-disabled-results" style="width:200px;" required>
          <option value="">Select Product</option>
          @foreach($driver as $row)
              <option value="{{ $row->id}}">{{ $row->name}}</option>
          @endforeach
        </select>
      </div>
     
      <div class="col-sm-2">
        <label> Doctor Name </label><br>
        <select name="doctor_id" id="doctor_id" class="js-example-disabled-results" style="width:200px;" required>
          <option value="">Select Doctor </option>
           @foreach($doctor as $row)
                <option value="{{ $row->id}}">{{ $row->name}}</option>
            @endforeach
        </select>
      </div>


      <div class="col-sm-4">
        <label>To Address</label>
        <input name="to_address" id="to_address" type="text" class="form-control form-control-sm" placeholder="" required />
      </div>


   

      <div class="col-sm-1">
        <label></label><br>
        <input type="submit" value="Submit" id="add_btn" class=" btn btn-success btn-sm" />
      </div>
    </div>

    <br>
    <ul class="alert alert-warning d-none" id="add_form_errlist"></ul>
  </form>
  <br>
</div>





       
   <div class="row">
       <div id="success_message"></div>

         <div class="col-md-12">
           <div class="table-responsive">
                <table class="table  table-bordered data-table">
                   <thead>
                     <tr>
                         <td> Appointment Id  </td>
                         <td> Date  </td>
                         <td> Name  </td>
                         <td> Phone </td>
                         <td> Address </td>
                         <td> Driver  </td>
                         <td> Doctor  </td>
                         <td> Status  </td>
                         <td> Edit  </td>
                         <td> Delete  </td>
                         <td> Started at  </td>
                         <td> Completed at  </td>
                       
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

        
            <div class="col-lg-6 ">
                  <label class=""> Driver Name <span style="color:red;"> * </span> </label>
                     <select class="form-select" name="driver_id" id="edit_driver_id" aria-label="Default select example">
                        <option value="">Select One</option>
                        @foreach($driver as $row)
                             <option value="{{ $row->id}}">{{ $row->name}}</option>
                         @endforeach
                    </select>
            </div>

            <div class="col-lg-6 ">
                  <label class=""> Doctor Name <span style="color:red;"> * </span> </label>
                     <select class="form-select" name="doctor_id" id="edit_doctor_id" aria-label="Default select example">
                        <option value="">Select One</option>
                        @foreach($doctor as $row)
                             <option value="{{ $row->id}}">{{ $row->name}}</option>
                         @endforeach
                    </select>
            </div>

            <div class="col-lg-6 ">
                <label for="roll">To Address <span style="color:red;"> * </span></label>
                <input type="text" name="to_address" id="edit_to_address" class="form-control" placeholder="" required>
                <p class="text-danger error_designation"></p>
            </div>

  
        


            <div class="col-lg-6 ">
                  <label class=""> Ambulance Status  <span style="color:red;"> * </span> </label>
                     <select class="form-select" name="status" id="edit_status" aria-label="Default select example">
                        <option value="1">Completed</option>
                        <option value="5">Canceled</option>
                        <option value="0">On Going</option>
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


<script src="{{ asset('js/ambulance_list.js') }}"></script>

      
<script>
  $(document).ready(function() {
    $(".js-example-disabled-results").select2();

     $(document).on('click', '.bazar_entry', function(e) {
      e.preventDefault();
            console.log('Rayhan babu');
      $('.bazar-entry-show').show();

    });


  });

  </script>
     








@endsection