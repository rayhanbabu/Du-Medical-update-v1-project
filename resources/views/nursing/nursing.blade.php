@extends('layouts/dashboardheader')
@section('page_title','Nursing Dashboard')
@section('nursing_list','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
  <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> Nursing Panel </h5></div>
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
                         <td> Appointment ID  </td>
                         <td> Date  </td>
                         <td> Name  </td>
                         <td> Care of  </td>
                         <td> Registration  </td>
                         <td> Seruvice Name  </td>
                         <td> Status  </td>
                         <td> Edit  </td>
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
           url: "{{ url('/nursing/nursing_list') }}",
           error: function(xhr, error, code) {
               console.log(xhr.responsediagnostic);
           }
       },
       order: [
            [6, 'asc'],   
            [0, 'desc']   
        ],
       columns: [
            {data: 'id', name: 'id'},
            {data: 'date', name: 'date'},
            {data: 'member_name', name: 'member_name'},
            {data: 'family_member_name', name: 'family_member_name'},
            {data: 'registration', name: 'registration'},
            {data: 'nursing_service', name: 'nursing_service'},
            {data: 'status', name: 'status'},
            {data: 'edit', name: 'edit', orderable: false, searchable: false},
          
       ]
   });
});

   </script>


    
@endsection