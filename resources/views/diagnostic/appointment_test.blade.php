@extends('layouts/dashboardheader')
@section('page_title','Diagnostic Dashboard')
@section('appointment_test','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
   <div class="card-header">
    <div class="row ">
        <div class="col-8"> <h5 class="mt-0"> Diagnostic Report  </h5></div>
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
                         <td> Appointment ID  </td>
                         <td> Date  </td>
                         <td> Name  </td>
                         <td> Careof </td>
                         <td> Registration  </td>
                         <td> Test Report Print  </td>
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
           url: "{{ url('/diagnostic/appointment_test') }}",
           error: function(xhr, error, code) {
               console.log(xhr.responsediagnostic);
           }
       },
       order: [[0, 'desc']],
       columns: [
            {data: 'id', name: 'id'},
            {data: 'date', name: 'date'},
            {data: 'member_name', name: 'member_name'},
            {data: 'family_member_name', name: 'family_member_name'},
            {data: 'registration', name: 'registration'},
            {data: 'link', name: 'link'},    
       ]
   });
});

   </script>


      



   


@endsection