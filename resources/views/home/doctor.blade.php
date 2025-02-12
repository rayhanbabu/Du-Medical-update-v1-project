@extends('layouts/memberheader')
@section('page_title','Diagnostic Dashboard')
@section('diagnostic_test','active')
@section('content')

  <div class="container my-4 border shadow">
    <h2 class="text-center my-3"> {{$category}} </h2>
    <hr>
    <div class="row">
      <!-- Card 1 -->
      @foreach($doctor as $row)
      <div class="col-md-3 col-sm-6 my-3">
        <div class="card">
          <img src="{{ !empty($row->image) ? asset('uploads/admin/'.$row->image) : asset('images/default2.png') }}" class="card-img-top" alt="Doctor Image">
          <div class="card-body">
          <div class="text-center"> 
            <h5 class="card-title"> {{$row->name}} </h5>
            <p class="card-text"> {{$row->designation}} </p>
             
             <a href="{{url('doctor-details/'.$row->id)}}" class="main-btn" class="w-100">View Detail</a>
             </div>
           
          </div>
        </div>
      </div>
      @endforeach
    
  
    </div>
  </div>


@endsection