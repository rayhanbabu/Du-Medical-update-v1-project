@extends('layouts/memberheader')
@section('page_title','Notice Dashboard')
@section('notice_test','active')
@section('content')

  <div class="container my-3 services-container">
    <h2 class="text-center mb-3"> Our Services </h2>
       <div class="row">

       @foreach($service as $row)
          <!-- Service Item 1 -->
          <div class="col-lg-3 col-md-6 mb-4">
             <div class="service-card">
               <img src="{{ asset('uploads/admin/'.$row->image)}}" alt="image" style="height: 100px; width: 150px; object-fit: cover; border-radius: 10%;">
                  <h5> {{$row->service_name}} </h5>
                <a class="main-btn" href="{{url('service-schedule/'.$row->service_name)}}">View Schedule</a>
             </div>
          </div>
       @endforeach

           <!-- Service Item 1 -->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="service-card">
            <img src="{{ asset('images/oncall.png')}}" alt="image" style="height: 100px; width: 150px; object-fit: cover; border-radius: 10%;">
               <h5> On Call Service </h5>
              <a class="main-btn" href="{{url('page-view/9')}}">View Details</a>
           </div>
         </div>


            <!-- Service Item 1 -->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="service-card">
            <img src="{{ asset('images/ambulance.png')}}" alt="image" style="height: 100px; width: 150px; object-fit: cover; border-radius: 10%;">
               <h5> Ambulance Service </h5>
              <a class="main-btn" href="{{url('page-view/6')}}"> View Details</a>
           </div>
         </div>


             <!-- Service Item 1 -->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="service-card">
            <img src="{{ asset('images/nursing.png')}}" alt="image" style="height: 100px; width: 150px; object-fit: cover; border-radius: 10%;">
               <h5> Nursing Service </h5>
              <a class="main-btn" href="{{url('page-view/10')}}"> View Details</a>
           </div>
         </div>


           <!-- Service Item 1 -->
        <div class="col-lg-3 col-md-6 mb-4">
          <div class="service-card">
            <img src="{{ asset('images/pathologist.png')}}" alt="image" style="height: 100px; width: 150px; object-fit: cover; border-radius: 10%;">
               <h5> Pathologist Service </h5>
              <a class="main-btn" href="{{url('page-view/4')}}"> View Details</a>
           </div>
         </div>


   
    </div>
  </div>


@endsection