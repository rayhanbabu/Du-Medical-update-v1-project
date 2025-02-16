@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('stock_available','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
  <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> Product Store Available List </h5></div>
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
                         <td> Generic/Category(Form) </td>
                         <td> Available Unit </td>
                         <td> Warning Unit </td>
                         <td> Warning Status </td>
                      
                       
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
           url: "{{ url('/admin/stock_available') }}",
           error: function(xhr, error, code) {
               console.log(xhr.responseText);
           }
       },
       order: [[3, 'desc']],
       columns: [
           
            {data: 'generic.generic_name', name: 'generic.generic_name'},
            {data: 'available_piece', name: 'available_piece'},
            {data: 'generic.warning_value', name: 'generic.warning_value'},
            {data: 'status', name: 'status'},

            
       ]
   });
});

   </script>


      



   


@endsection