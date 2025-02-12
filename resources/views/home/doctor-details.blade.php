@extends('layouts/memberheader')
@section('page_title','Diagnostic Dashboard')
@section('diagnostic_test','active')
@section('content')


<div class="container my-5 ">
    <div class="d-flex align-items-center justify-content-center flex-col">

    <div class="doctor-profile row  mt-3">
      <!-- Doctor Image -->
      <div class="col-lg-4 col-md-5 col-sm-12 d-flex justify-content-center mb-4 mb-lg-0">
        <img src="{{ !empty($data->image) ? asset('uploads/admin/'.$data->image) : asset('images/default2.png') }}" alt="Doctor Image">
      </div>
      <!-- Doctor Profile Details -->
      <div class="col-lg-8 col-md-7 col-sm-12 profile-details">
        <h5>Profile Details</h5>
        <p><strong>Name:</strong> {{$data->name}}</p>
        <p><strong>Degree:</strong> {{$data->degree}}</p>
        <p><strong>Designation:</strong> {{$data->designation}}</p>
        <p><strong>Department:</strong> {{$data->department}}</p>
        <p><strong>Phone:</strong>{{$data->phone}}</p>
        <p><strong>Email:</strong> {{$data->email}}</p>
      </div>
    </div>
    </div>
  </div>


@endsection