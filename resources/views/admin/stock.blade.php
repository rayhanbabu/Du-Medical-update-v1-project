@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('stock','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
  <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> Product Store List </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                           <a class="btn btn-primary btn-sm" href="{{url('admin/stock/manage')}}" role="button"> Add </a>
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
                        <td>ID </td>
                         <td> Generic/Category(Form) </td>
                         <td> Brand Name </td>
                         <td> Medicine Name </td>
                         <td> Box </td>
                         <td> Box per unit</td>
                         <td> Total Unit </td>
                         <td> Cost Per Unit </td>
                         <td> Total Cost </td>
                         <td> Stock Status </td>
                         <td> Edit </td>
                         <td> Delete </td>
                         <td> Available Unit </td>
                         <td> Stock By </td>
                         <td> Expired Date </td>
                         <td> MGF Date </td>
                         <td> Batch </td>
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
           url: "{{ url('/admin/stock') }}",
           error: function(xhr, error, code) {
               console.log(xhr.responseText);
           }
       },
       order: [[0, 'desc']],
       columns: [
            {data: 'id', name: 'id'},
            {data: 'generic.generic_name', name: 'generic.generic_name'},
            {data: 'brand.brand_name', name: 'brand.brand_name'},
            {data: 'medicine_name', name: 'medicine_name'},
            {data: 'box', name: 'box'},
            {data: 'piece_per_box', name: 'piece_per_box'},
            {data: 'total_piece', name: 'total_piece'},
            {data: 'cost_per_piece', name: 'cost_per_piece'},
            {data: 'total_amount', name: 'total_amount'},
            {data: 'status', name: 'status'},
            {data: 'edit', name: 'edit', orderable: false, searchable: false},
            {data: 'delete', name: 'delete', orderable: false, searchable: false},
            {data: 'available_piece', name: 'available_piece'},
            {data: 'create.name', name: 'create.name'},
            {data: 'expired_date', name: 'expired_date'},
            {data:'mgf_date', name:'mgf_date'},
            {data: 'batch_no', name: 'batch_no'}

            
       ]
   });
});

   </script>


      



   


@endsection