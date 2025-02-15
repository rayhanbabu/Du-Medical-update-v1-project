@extends('layouts/dashboardheader')
@section('page_title','Diagnostic Dashboard')
@section('test_list','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
  <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> Diagnostic Report Setup </h5></div>
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                             
                                     
                         </div>
                     </div>

                    
                     <div class="col-2">
                         <div class="d-grid gap-2 d-md-flex ">
                           <a class="btn btn-primary btn-sm" href="{{url('diagnostic/setup')}}" role="button"> Add </a>
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
                         <td> App ID  </td>
                         <td> Date  </td>
                         <td> Name  </td>
                         <td> Careof </td>
                         <td> Phone  </td>
                         <td> Test Category  </td>
                         <td> Tested Status  </td>
                         <td> Checked Status  </td>
                         <td> Edit  </td>
                         <td> Print  </td>
                         <td> Tested By  </td>
                         <td> Checked By  </td>
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
           url: "{{ url('/diagnostic/test_list') }}",
           error: function(xhr, error, code) {
               console.log(xhr.responsediagnostic);
           }
       },
       order: [
            [1, 'desc']   
        ],
       columns: [
            {data: 'appointment_id', name: 'appointment_id'},
            {data: 'date', name: 'date'},
            {data: 'member.member_name', name: 'member.member_name'},
            {data: 'member.member_name', name: 'member.member_name'},
            {data: 'member.phone', name: 'member.phone'},
            {data: 'testcategory.testcategory_name', name: 'testcategory.testcategory_name'},
            {data: 'tested_status', name: 'tested_status'},
            {data: 'checked_status', name: 'checked_status'},
            {data: 'edit', name: 'edit', orderable: false, searchable: false},
            {data: 'link', name: 'link', orderable: false, searchable: false},
            {data: 'tested', name: 'tested'},
            {data: 'checked', name: 'checked'},
          
       ]
   });
});

   </script>


      



   


@endsection