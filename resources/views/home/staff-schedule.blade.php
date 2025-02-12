@extends('layouts/memberheader')
@section('page_title','Staff Dashboard')
@section('staffschedule','active')
@section('content')

@foreach($data as $row)
   <div class="container my-4 border shadow">
        <h3 class="text-center my-3"> {{$row->userType}} Service Sehedule </h3>
         <hr>
         <div class="row">
         <div class="col-md-12">
           <div class="table-responsive">
                <table class="table  table-bordered data-table">
                   <thead>
                     <tr>
                         <th> Name </th>
                         <th> Saturday  </th>
                         <th> Sunday </th>
                         <th> Monday </th>
                         <th> Tuesday </th>
                         <th> Wednesday </th>
                         <th> Thursday </th>
                         <th> Friday </th>
                      </tr>
                   </thead>
                   <tbody>
                   @foreach(user_detail($row->userType) as $item)
                       <tr>
                         <td> {{$item->name}} </td>
                         <td> {{staff_duty($item->id,'Saturday')}}</td>
                         <td> {{staff_duty($item->id,'Sunday')}}</td>
                         <td> {{staff_duty($item->id,'Monday')}}</td>
                         <td> {{staff_duty($item->id,'Tuesday')}}</td>
                         <td> {{staff_duty($item->id,'Wednesday')}}</td>
                         <td> {{staff_duty($item->id,'Thursday')}}</td>
                         <td> {{staff_duty($item->id,'Friday')}}</td>
                       </tr>
                    @endforeach    
                   </tbody>

                </table>
          </div>
       </div>
    </div>
   </div>
   @endforeach


@endsection