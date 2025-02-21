@extends('layouts/dashboardheader')
@section('page_title','Product Request Dashboard')
@section('product_request','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
  <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> Product Request List</h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                           <a class="btn btn-primary btn-sm" href="{{url('/admin/product_request/setup')}}" role="button"> Add </a>
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
                         <td> Request ID  </td>
                         <td> Date  </td>
                         <td> Request From  </td>
                         <td> View </td>
                         <td> CMO Status  </td>
                         <td> Received Status  </td>
                         <td> Print  </td>
                         <td> Delete  </td>
                         <td> Requested By  </td>
                         <td> Approved By  </td>
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
        <h5 class="modal-title" id="exampleModalLabel"> Product Details </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" id="edit_employee_form" enctype="multipart/form-data">
      
        <div class="modal-body p-4 bg-light">
          <div class="row">
          
            <div class="col-lg-6">
                 <label for="roll"> Product Request Id </label>
                 <input type="text" class="form-control" name="edit_id" id="edit_id" readonly>
            </div>


             <!-- Product Table -->
            <div class="product_table">
                  <table class="table table-bordered product_table">
                      <thead>
                       <tr>
                           <th> Request From </th>
                           <th> Generic/ Product category </th>
                           <th> Product Name </th>
                           <th> Qty </th>
                      </tr>
              </thead>
                     <tbody>
                <!-- Dynamic rows will be appended here -->
                   </tbody>
            </table>
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


<script src="{{ asset('js/productrequest_setup.js') }}"></script>
  <script>
          $(function() {
    var table = $('.data-table').DataTable({
         processing: true,
         serverSide: true,
       ajax: {
            url: "{{ url('/admin/product_request') }}",
            error: function(xhr, error, code) {
               console.log(xhr.responsediagnostic);
            }
       },
       order: [
            [1, 'desc']   
        ],
       columns: [
            {data: 'id', name: 'id'},
            {data: 'date', name: 'date'},
            {data: 'request_from', name: 'request_from'},
            {data: 'view', name: 'view'},
            {data: 'cmo_status', name: 'cmo_status'},
            {data: 'cmo_status', name: 'cmo_status'},
            {data: 'cmo_status', name: 'cmo_status'},
            {data: 'delete', name: 'delete', orderable: false, searchable: false},
            {data: 'request_by', name: 'request_by'},
            {data: 'provide_by', name: 'provide_by'},
          
       ]
   });
});

   </script>


      



   


@endsection