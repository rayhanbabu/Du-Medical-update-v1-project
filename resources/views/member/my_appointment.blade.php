@extends('layouts/memberheader')
@section('page_title','Diagnostic Dashboard')
@section('diagnostic_test','active')
@section('content')

  
<div class="container p-3">
  <div class="card mt-2 mb-2 shadow-sm">
     <div class="card-header">
         <div class="row ">
               <div class="col-8"> <h5 class="mt-0"> My Appointment History  </h5></div>
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
         <div class="col-md-12">
           <div class="table-responsive">
                <table class="table  table-bordered data-table">
                   <thead>
                     <tr>
                         <th> Date & Time </th>
                         <th> Appointment Id </th>
                         <th> Room </th>
                         <th> Appointment Slip </th>
                         <th> Feedback </th>
                         <th> Service Details </th>
                      </tr>
                   </thead>
                   <tbody>
                       @foreach ($appointment as $row)
                         <tr>
                             <td> {{$row->date}} , {{$row->slot_time}}  </td>
                             <td> {{$row->id}} </td>
                             <td> {{$row->room}}  </td>
                               <td> <a href="{{ url('/appointment/slip?appointment_id='.$row->id) }}" class="btn btn-success btn-sm">
                                       Slip
                                    </a>  
                                 </td>
                             <td> 
                               @if($row->appointment_status==1)
                                   <a href="{{ url('/appointment/feedback?appointment_id='.$row->id) }}" class="btn btn-success btn-sm">
                                         Feedback
                                    </a>
                                @endif    
                             </td>
                             <td>
                                
                              @if($row->appointment_status==1)
                                 <a href="{{ url('/prescription/'.$row->id) }}" class="btn btn-success btn-sm">
                                     Prescription
                                 </a>
                            
                                  <a href="{{ url('/diagnostic/report/'.$row->id) }}" class="btn btn-success btn-sm">
                                         Test
                                  </a>
                               @else
                               <a href="#" class="btn btn-danger btn-sm"> Pending </a>
                               @endif

                                  
                            </td>
                         </tr>
                       @endforeach
                   </tbody>

                </table>
          </div>
       </div>
    </div>


  </div>
</div>
</div>





@endsection