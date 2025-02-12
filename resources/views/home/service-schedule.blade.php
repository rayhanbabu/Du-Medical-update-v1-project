@extends('layouts/memberheader')
@section('page_title','Doctor Dashboard')
@section('service_form','active')
@section('content')

   <div class="container my-4 border shadow">
        <h2 class="text-center my-3"> {{$service_name}} Service Sehedule </h2>
         <hr>
         <div class="row">
         <div class="col-md-12">
           <div class="table-responsive">
                <table class="table  table-bordered data-table">
                   <thead>
                     <tr>
                         <th> Doctor Name </th>
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
                     @foreach($chamber as $row)
                        <tr>
                             <td> {{ $row->name }} </td>
                             <td> {{ slot_time($row->user_id,$row->id,'Saturday') }} </td>
                             <td> {{ slot_time($row->user_id,$row->id,'Sunday') }} </td>
                             <td> {{ slot_time($row->user_id,$row->id,'Monday') }} </td>
                             <td> {{ slot_time($row->user_id,$row->id,'Tuesday') }} </td>
                             <td> {{ slot_time($row->user_id,$row->id,'Wednesday') }} </td>
                             <td> {{ slot_time($row->user_id,$row->id,'Thursday') }} </td>
                             <td> {{ slot_time($row->user_id,$row->id,'Friday') }} </td>
                        </tr>
                     @endforeach
                        
                   </tbody>

                </table>
          </div>
       </div>
    </div>
   </div>


@endsection