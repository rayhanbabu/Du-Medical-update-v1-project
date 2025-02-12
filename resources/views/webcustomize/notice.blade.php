@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('notice','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
  <div class="row ">
               <div class="col-8"> <h5 class="mt-0">{{$pagecategory->page_name}}   Content </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    


                    
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                           <a class="btn btn-primary btn-sm" href="{{url('admin/notice/manage/'.$pagecategory_id)}}" role="button"> Add </a>
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
                         <td> Image </td>
                         <td> Serial </td>
                         <td> Date </td>
                         <td> Title </td>
                         <td> Status</td>
                         <td> Edit </td>
                         <td> Delete </td>
                         <td> Link </td>
                         <td> Short Description </td>
                         <td> Description </td>
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
           url: "{{ url('/admin/notice/'.$pagecategory_id) }}",
           error: function(xhr, error, code) {
               console.log(xhr.responsenotice);
           }
       },
       columns: [
            {data: 'image', name: 'image'},
            {data: 'serial', name: 'serial'},
            {data: 'date', name: 'date'},
            {data: 'title', name: 'title'},
            {data: 'status', name: 'status'},
            {data: 'edit', name: 'edit', orderable: false, searchable: false},
            {data: 'delete', name: 'delete', orderable: false, searchable: false},
            {data: 'link', name: 'link'},
            {data: 'short_desc', name: 'short_desc'},
            {data: 'desc', name: 'desc'},
       ]
   });
});

   </script>


      



   


@endsection