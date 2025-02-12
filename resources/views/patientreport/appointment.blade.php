@extends('layouts/dashboardheader')
@section('page_title','Nursing Dashboard')
@section('nursing_test','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
  <form  method="POST" id="add_appointment_form" enctype="multipart/form-data">
  <div class="row ">
               <div class="col-6"> <h5 class="mt-0"> Patient Report/ Appointment </h5></div>
             
                      <div class="col-4">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                         <input type="text" name="registration" id="registration" class="form-control" placeholder="Enter Registration/ Employee Id" required>
                                     
                         </div>
                     </div>

                    
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                         <button type="submit" id="add_appointment_btn" class="btn btn-primary">Search </button>                   
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
                         <td> Appointment ID  </td>
                         <td> Name  </td>
                         <td> Registration  </td>
                         <td> Disease Problem </td>
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


    
@endsection