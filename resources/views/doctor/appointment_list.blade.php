@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('appointment_list','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
  <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> Appointment List </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                          
                         </div>
                     </div> 
         </div>
           
         @if(Session::has('fail'))
             <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
         @endif
                        
        @if(Session::has('success'))
              <div  class="alert alert-success"> {{Session::get('success')}}</div>
            @endif


      </div>
  <div class="card-body">   

   <div class="row">
         <div class="col-md-12">
           <div class="table-responsive">
                <table class="table  table-bordered data-table">
                   <thead>
                    
                     <tr>
                         <td> Id  </td>
                         <td> Date  </td>
                       
                         <td> Name  </td>
                         <td> Careof </td>
                         <td> Phone </td>
                         <td> Registration  </td>
                         <td> Service Name </td>
                         <td> Room </td>
                         <td> Prescription </td>
                         <td> Edit </td>
                       
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




<script>
       $(function() {
   var table = $('.data-table').DataTable({
       processing: true,
       serverSide: true,
       ajax: {
           url: "{{ url('/doctor/appointment_list') }}",
           error: function(xhr, error, code) {
               console.log(xhr.responseText);
           }
       },
       order: [
            [0, 'desc']   
        ],
       columns: [
            {data: 'id', name: 'id'},
            {data: 'date', name: 'date'},
         
            {data: 'member.member_name', name: 'member.member_name'},
            {
             data: 'careof.family_member_name',
             name: 'careof.family_member_name',
             render: function(data, type, row) {
               return data ? data : ''; // Replace 'N/A' with whatever default you want
            }
           },
           
            {data: 'member.phone', name: 'member.phone'},
            {data: 'member.registration', name: 'member.registration'} , 
            {data: 'service_name', name: 'service_name'},
            {data: 'room', name: 'room'},
            {data: 'prescription', name: 'prescription'},
            {data: 'edit', name: 'edit', orderable: false, searchable: false},
           
       ]
   });
});

   </script>


      



   


@endsection