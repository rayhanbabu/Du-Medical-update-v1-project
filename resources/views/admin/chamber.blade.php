@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('chamber','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
  <div class="row ">
               <div class="col-8"> <h5 class="mt-0">Chamber  </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                           <a class="btn btn-primary btn-sm" href="{{url('admin/chamber/manage')}}" role="button"> Add </a>
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
                         <td> Serial </td>
                         <td> Chamber  </td>
                         <td> Service  </td>
                         <td> Doctor  </td>
                         <td> Chamber Type </td>
                         <td> Room   </td>
                         <td> Status</td>
                         <td> Slot Setup</td>
                         <td> Edit </td>
                         <td> Delete </td>
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
           url: "{{ url('/admin/chamber') }}",
           error: function(xhr, error, code) {
               console.log(xhr.responsechamber);
           }
       },
       columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'chamber_name', name: 'chamber_name'},
            {data: 'service_name', name: 'service_name'},
            {data: 'name', name: 'name'},
            {data: 'chamber_type', name: 'chamber_type'},
            {data: 'room', name: 'room'},
            {data: 'status', name: 'status'},
            {data: 'slot', name: 'slot', orderable: false, searchable: false},
            {data: 'edit', name: 'edit', orderable: false, searchable: false},
            {data: 'delete', name: 'delete', orderable: false, searchable: false},
       ]
   });
});

   </script>


      



   


@endsection