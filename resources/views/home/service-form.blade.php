@extends('layouts/memberheader')
@section('page_title','Doctor Dashboard')
@section('service_form','active')
@section('content')

   <div class="container my-4 border shadow">
        <h2 class="text-center my-3"> Service Form </h2>
         <hr>
         <div class="row">
         <div class="col-md-12">
           <div class="table-responsive">
                <table class="table  table-bordered data-table">
                   <thead>
                     <tr>
                         <th> Title </th>
                         <th> Download </th>
                      </tr>
                   </thead>
                   <tbody>
                       @foreach ($data as $row)
                         <tr>
                             <td> {{$row->title}} </td>
                               <td> <a href="{{ url('uploads/admin/'.$row->image) }}" class="btn btn-success btn-sm">
                                       Download
                                    </a>  
                             </td>  
                         </tr>
                       @endforeach
                   </tbody>

                </table>
          </div>
       </div>
    </div>
   </div>


@endsection