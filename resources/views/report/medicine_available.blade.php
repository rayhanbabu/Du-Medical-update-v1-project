@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('week','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
  <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> Available Product Report </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    
                   <div class="col-2">
                       <div class="d-grid gap-2 d-md-flex ">
                          
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
                      
                         <td> Generic / Product Category  </td>                  
                         <td> Total Available Unit  </td>
                         <td>  Status  </td>
                      
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
           url: "{{ url('/report/medicine_available') }}",
           error: function(xhr, error, code) {
               console.log(xhr.response);
           }
       },
       columns: [
            {data: 'generic_name', name: 'generic_name'},
            {data: 'available_piece', name: 'available_piece'},
            {data: 'status', name: 'status'},
         ]
   });
});

   </script>

      
     








@endsection