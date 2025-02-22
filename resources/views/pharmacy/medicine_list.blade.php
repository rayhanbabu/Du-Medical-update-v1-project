@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('medicine_list','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
  <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> Pharmacy Panel </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    
                   <div class="col-2">
                       <div class="d-grid gap-2 d-md-flex ">
                              <a class="btn btn-primary btn-sm" href="{{url('pharmacy/setup')}}" role="button"> Add </a>
                       </div>
                     </div> 
         </div>
           
      </div>
  <div class="card-body">   
       
   <div class="row">
       <div id="success_message"></div>

         <div class="col-md-12">
           <div class="table-responsive">
                <table class="table  table-bordered data-table">
                   <thead>
                     <tr>
                          <td> Appointment ID  </td>
                          <td> Date  </td>
                          <td> Name  </td>
                          <td> Care of  </td>
                          <td> Registration  </td>
                          <td> Medicine View  </td>
                          <td> Delete  </td>
                          <td> Created By  </td>
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

<script src="{{ asset('js/medicine_list.js') }}"></script>

      
     








@endsection