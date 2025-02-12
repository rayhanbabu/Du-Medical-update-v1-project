@extends('layouts/memberheader')
@section('page_title','Diagnostic Dashboard')
@section('diagnostic_test','active')
@section('content')

  
     <!-- Header -->
     <header class="container-fluid py-3 bg-light border-bottom">
      <div class="d-flex container justify-content-between align-items-center">
        <div id="appointmentDetails" class="appointment_details">
            <h3>Appointment Details</h3>
            <p>
                <strong> Date : </strong> <span id="appointmentDate"> {{$date}} </span> |
                <strong> Service : </strong> <span id="appointmentSector"> {{ $service_name }} </span> 
            </p>
        </div>
        <div>
            <button id="modifyBtn" class="btn btn-primary" onclick="modifySearch()">Modify Search</button>
        </div>
    </div>
    
    </header>


    <!-- Main Container -->
    <div class="container mt-4">
      <div class="row">
        <!-- Table Section -->
        <div
          class="col-md-8 border pt-4"
          style="border-radius: 10px; box-shadow: 10px 10px 10px #0000000a">

           @foreach ($chamber_detail as $row)
                @if($row->id==$chamber_id)
                   <a href="{{ url('/service/search?date='.$date.'&service_name='.$service_name.'&chamber_id='.$row->id) }}" class="btn btn-success">
                      {{$row->chamber_name}}
                   </a>
                @else
                    <a href="{{ url('/service/search?date='.$date.'&service_name='.$service_name.'&chamber_id='.$row->id) }}" class="btn btn-light">
                     {{$row->chamber_name}}
                     </a>
                @endif
           @endforeach 
        <hr>
     
        
        
        <div class="row p-2"> 
       <div class="col-3">
    <span style="display: inline-block; width: 20px; height: 20px; background-color: red; border-radius: 50%;"></span>
    <span style="margin-left: 10px;">Booked</span>
</div>

 
 <div  class="col-3">
     <span style="display: inline-block; width: 20px; height: 20px; background-color: green; border-radius: 50%;"></span>
     <span style="margin-left: 10px;">Available</span>
 </div>


   </div>
       @foreach(slotbychamber($chamber_id,'Online',$week) as $item)
                @if(appointmentDetail($item->service_name, $item->id)==$item->id)
                     <button type="button" class="btn btn-danger btn-sm disabled m-1" style="width: 140px;">Booked </button>
                 @elseif($item->slot_type=='Online')
                     <button type="button" data-date="{{$date}}" data-slot_id="{{$item->id}}" data-slot_time="{{$item->slot_time}}" id="add_employee_btn_{{$item->id}}" class="appointment_cart btn btn-success btn-sm m-1" style="width: 140px;" >{{ $item->slot_time }}</button>
                 @else
                     <button type="button" class="btn btn-info btn-sm disabled m-1" style="width: 140px;" >{{$item->slot_type}} </button>
                  @endif
           @endforeach
        </div>

        <!-- Content Box Section -->
        <div class="col-md-4">
          <div class="content-box">

            <h4>Appointment Details</h4>
            <table class="table" id="data-table">
      <thead>
         <tr>
             <th scope="col">Time</th>
            <th scope="col">Delete</th>
        </tr>
      </thead>
      <tbody>
     
      </tbody>
    </table>

       <form method="POST" id="appointment_form" enctype="multipart/form-data">

             <input type="hidden" name="appointment_id" id="appointment_id">

             <div class="mb-3">
               <label for="problem" class="form-label"> Describe  Disease Problem </label>
                 <textarea
                    class="form-control"
                    id="problem"
                    rows="4"
                    name="disease_problem"
                    placeholder="Describe your problem here"
                 ></textarea>
               </div>

              <div class="mb-3">
                  <label for="file" class="form-label">Choose File</label>
                  <input class="form-control" name="image" type="file" id="file" />
              </div>

              <button  type="submit" id="appointment_button" class="btn btn-primary btn-custom">Submit</button>
        
            </form>

          </div>
        </div>
      </div>
    </div>


    <script src="{{ asset('frontend/js/service.js') }}"></script>

    <script>
      function modifySearch() {
    const appointmentDetails = document.getElementById("appointmentDetails");
    
    const currentDate = document.getElementById("appointmentDate").textContent;
    const currentSector = document.getElementById("appointmentSector").textContent;
    
    // Replace the content with input fields and buttons
    appointmentDetails.innerHTML = `
      <h3>Modify Appointment Details</h3>
      <form id="modifyForm">
        <div class="form-row d-flex align-items-center">
          <div class="form-group ">
            <label for="dateInput"><strong>Date:</strong></label>
            <input type="text" id="dateInput" class="form-control" value="${currentDate}">
          </div>
          <div class="form-group ">
            <label for="sectorInput"><strong>Sector:</strong></label>
            <input type="text" id="sectorInput" class="form-control" value="${currentSector}">
          </div>
          </br>
          <div class="form-group mt-3">
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="button" class="btn btn-secondary ml-2" onclick="closeForm()">Close</button>
          </div>
        </div>
      </form>
    `;

    // Add form submission handling
    document.getElementById("modifyForm").addEventListener("submit", function(e) {
      e.preventDefault();
      
      const newDate = document.getElementById("dateInput").value;
      const newSector = document.getElementById("sectorInput").value;
      
      // Update the original content
      appointmentDetails.innerHTML = `
        <h3>Appointment Details</h3>
        <p>
          <strong>Date:</strong> <span id="appointmentDate">${newDate}</span> |
          <strong>Sector:</strong> <span id="appointmentSector">${newSector}</span>
        </p>
      `;
    });
  }

  function closeForm() {
    const appointmentDetails = document.getElementById("appointmentDetails");
    // const currentDate = document.getElementById("appointmentDate").textContent;
    // const currentSector = document.getElementById("appointmentSector").textContent;
    const newDate = document.getElementById("dateInput").value;
      const newSector = document.getElementById("sectorInput").value;
      
    // Restore the original content
    appointmentDetails.innerHTML = `
        <h3>Appointment Details</h3>
        <p>
          <strong>Date:</strong> <span id="appointmentDate">${newDate}</span> |
          <strong>Sector:</strong> <span id="appointmentSector">${newSector}</span>
        </p>
      `;
  }
    </script>




@endsection