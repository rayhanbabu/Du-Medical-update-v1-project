@extends('layouts/memberheader')
@section('page_title','Diagnostic Dashboard')
@section('diagnostic_test','active')
@section('content')


  <!-- banner -->
  <div class="banner container ">
      <div class="slider my-5">

         @foreach($slider as $row)
          <div class="slider_item">
            <img
              src="{{asset('uploads/admin/'.$row->image)}}"
              alt="banner_image"
            />
          </div>
        @endforeach
       
      </div>
    </div>


<!-- ---- -->
<div class="navigation_ my-2" style="background-color: #695cd4;">
  <div class="container py-4">
    <div class="row g-3">
      <!-- Column 1 -->
      <div class="col-md-3 col-sm-6 col-12 text-center">
        <a href="{{url('service')}}">
        <div class="box" style="width: 200px; height: 210px; margin: 0 auto;">
          <div class="logo">
            <img src="{{asset('frontend/img/customer.png')}}" alt="service image" class="img-fluid">
          </div>
          <p class="text-white">Service</p>
        </div>
       </a>
      </div>
      <!-- Column 2 -->
      <div class="col-md-3 col-sm-6 col-12 text-center">
      <a href="{{url('member/login')}}">
        <div class="box" style="width: 200px; height: 210px; margin: 0 auto;">
          <div class="logo">
            <img src="{{asset('frontend/img/time.png')}}" alt="appointment image" class="img-fluid">
          </div>
          <p class="text-white">Make Appointment</p>
        </div>
      </a>
      </div>
      <!-- Column 3 -->
      <div class="col-md-3 col-sm-6 col-12 text-center">
      <a href="{{url('/staff-schedule')}}">
        <div class="box" style="width: 200px; height: 210px; margin: 0 auto;">
          <div class="logo">
            <img src="{{asset('frontend/img/schedule.png')}}" alt="schedule image" class="img-fluid">
          </div>
          <p class="text-white">Stuff Duty Schedule</p>
        </div>
     </a>
      </div>

      <!-- Column 4 -->
      <div class="col-md-3 col-sm-6 col-12 text-center">
        <a href="{{url('page-view/6')}}">
           <div class="box" style="width: 200px; height: 210px; margin: 0 auto;">
             <div class="logo">
               <img src="{{asset('frontend/img/ambulance.png')}}" alt="ambulance image" class="img-fluid">
            </div>
            <p class="text-white text-wrap"> Ambulance Service </p>
          </div>
       </a>
      </div>
    </div>
  </div>
</div>

  
  <!-- banner -->
  <div class="message my-3">
  <div class="container p-3 shadow bg-white">
    <div class="row ">
      <!-- Image column -->
      <div class="col-md-3 col-sm-12 text-center mb-3">
        <img src="{{ asset('uploads/admin/'.$welcome->image) }}" alt="doctor" class="img-fluid ">
        <div class="mt-2">
             <strong> {{$welcome->title}}  </strong>
               <p> {{$welcome->title}}  </p>
        </div>
      </div>
      <!-- Text column -->
      <div class="col-md-9 col-sm-12">
        <h3 style="color:#695cd4;">Message from CMO</h3>
        <p style="font-size: 18px;"> {!! $welcome->short_desc !!} </p>
        <!-- <button class="main-btn">Read More...</button> -->
      </div>
    </div>
  </div>
</div>


<div class="news">
  <div class="container border pb-5">
    <h2 class="text-center my-3">News & Events</h2>
    <hr>
    <div class="news-slider my-2 ">


     @foreach($news as $row)
      <div class="slider_box shadow p-3">

       <a href="{{url('notice-details/'.$row->id)}}">
        <div class="">
          <img src="{{asset('uploads/admin/'.$row->image)}}" alt="image" style="height: 230px; object-fit: cover;width: 100%;">
        </div>
        <div>
          <p class="mt-3"> {{$row->date}} </p>
          <h5> {{$row->title}} </h5>
         
         </div>
      </a>

    </div>
   @endforeach

  
  
    </div>
  </div>
 </div>


@endsection