@extends('layouts/memberheader')
@section('page_title','Diagnostic Dashboard')
@section('diagnostic_test','active')
@section('content')

  <div class="container appointment-container">
      <div class="appointment-content">
        <!-- Left Side: Form -->

    <div class="appointment-form">
        <form method="get" action="{{ url('service/search') }}" class="myform" enctype="multipart/form-data" >
             <div class="mb-3">
                 <label for="appointment-date" class="form-label">Select Date</label>
                 <input type="date" name="date" class="form-control" id="date" required />
            </div>
          
            <div class="mb-3">
                 <label for="appointment-type" class="form-label">Select Service Type</label>
                  <select class="form-select" name="service_name" id="service" required>  
                        <option value=""> Select One </option>
                         @foreach($service as $row)
                          <option value="{{$row->service_name}}"> {{$row->service_name}} </option>
                         @endforeach
                  </select>
            </div>

            @if(Session::has('fail'))
                <div  class="alert alert-danger"> {{Session::get('fail')}}</div>
            @endif

  
            <br> 
            <button type="submit" class="btn btn-primary w-100"> Search </button>
          </form>
        </div>
  
        <!-- Right Side: Image -->
        <div class="appointment-image">
          <img
            src="https://www.ethika.co.in/wp-content/uploads/2022/06/annual-health-checkup.jpg"
            alt="Health Checkup"
            class="appointment-img"
          />
        </div>
      </div>
    </div>
  



@endsection