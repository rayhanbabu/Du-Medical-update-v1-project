@extends('layouts/dashboardheader')
@section('page_title','Nursing Dashboard')
@section('nursing_test','active')
@section('content')

 <div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
    <form  method="POST" id="add_diagnostic_form" enctype="multipart/form-data">
       <div class="row">
               <div class="col-6"> <h5 class="mt-0"> Patient Report / Diagnostic </h5></div>
             
                      <div class="col-4">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                         <input type="text" name="registration" id="registration" class="form-control" placeholder="Enter Registration/ Employee Id" required>
                                     
                         </div>
                     </div>

                    
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                         <button type="submit" id="add_diagnostic_btn" class="btn btn-primary">Search </button>                   
                         </div>
                     </div> 

               </form>   
         </div>
           
       


      </div>
  <div class="card-body">   

   <div class="row">
         <div class="col-md-12">
            
           <div class="table-responsive">
                <table class="table  table-bordered" id="data-table">
                   <thead>
                     <tr>
                          <td> Date  </td>
                          <td> Appointment Id  </td>
                          <td> Name  </td>
                          <td> Registration  </td>
                          <td> Test Name </td>
                          <td> View  </td>
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




<script src="{{ asset('js/patientreport.js') }}"></script>



{{-- edit employee modal start --}}
<div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Diagnostic Report </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" id="edit_employee_form" enctype="multipart/form-data">
        <input type="hidden" name="edit_id" id="edit_id">
        <div class="modal-body p-4 bg-light">
          <div class="row">

         

          <div class="table-responsive">
                <table class="table  table-bordered" id="result-table">
                   <thead>
                     <tr>
                          <td> Diagnostic Name  </td>
                          <td> Result </td>
                          <td> Reference  </td>
                    
                      </tr>
                   </thead>
                   <tbody>

                   </tbody>

                </table>
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


    
@endsection