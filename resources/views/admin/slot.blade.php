@extends('layouts/dashboardheader')
@section('page_title','Admin Dashboard')
@section('slot','active')
@section('content')

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
    <div class="row">
      <div class="col-sm-7">
        <h6 class="mt-0">Chamber Name: <b> {{$chamber->chamber_name}} </b> ,
             Service: <b> {{$chamber->service_name}} </b> ,
             Chamber Type:<b>{{$chamber->chamber_type}}</b>, Doctor:<b>{{$chamber->name}}</b>
      
        </h6>
      </div>


      <div class="col-sm-2"> 
            <a class="btn btn-primary btn-sm" href="{{url('admin/chamber')}}" role="button"> Back Chamber </a>
      </div>

      <div class="col-sm-3">
        <form method="get" enctype="multipart/form-data">
          <div class="d-grid gap-2 d-md-flex ">
            <select name="week_name" id="week_name" class="form-select" required>
              <option value="">Select Day </option>
              @foreach($week as $row)
              <option value="{{ $row->week_name }}">
                {{ $row->week_name }}
              </option>
              @endforeach
            </select>
            <input type="submit" id="insert" value="Search" class="btn btn-success" />
          </div>
        </form>
      </div>


    </div>
  </div>
</div>

@if($week_name)

<div class="card mt-2 mb-2 shadow-sm">
  <div class="card-header">
    <div class="row ">
      <div class="col-8">
        <h5 class="mt-0"> <b> {{$week_name}}  </b> Slot Allocation </h5>
      </div>
      <div class="col-2">
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">


        </div>
      </div>


      <div class="col-2">
        <div class="d-grid gap-2 d-md-flex ">
          <a class="btn btn-primary btn-sm" href="{{url('admin/slot/manage/'.$chamber->id.'/'.$week_name)}}" role="button"> Add </a>
        </div>
      </div>
    </div>

    @if(Session::has('fail'))
    <div class="alert alert-danger"> {{Session::get('fail')}}</div>
    @endif

    @if(Session::has('success'))
    <div class="alert alert-success"> {{Session::get('success')}}</div>
    @endif


  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-8 mt-2 p-3 shadow">
        <div class="table-responsive">
        <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>Serial</th>
                            <th>Slot Time</th>
                            <th>Slot Type</th>
                            <th>Duty Type</th>
                            <th>Booking Last Time</th>
                            <th>Slot Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- DataTable will populate this tbody -->

        @foreach($data as $item)
           <tr>
            <td>{{ $item->serial }}</td>
            <td>{{ $item->slot_time }}</td>
            <td>{{ $item->slot_type }}</td>
            <td>{{ $item->duty_type }}</td>
            <td>{{ $item->booking_last_time }}</td>
            <td>{{ $item->slot_status == '1' ? 'Active' : 'Inactive' }}</td>
            <td><a href="/admin/slot/manage/{{ $chamber->id }}/{{ $item->week_name }}/{{ $item->id }}" class="edit btn btn-primary btn-sm">Edit</a></td>
            <td><a href="/admin/slot/delete/{{ $item->id }}" onclick="return confirm('Are you sure you want to delete this item?')" class="delete btn btn-danger btn-sm">Delete</a></td>
         </tr>
        @endforeach
                    </tbody>
                </table>
        </div>
      </div>


      <div class="col-md-4 mt-2 p-3 shadow">
        <div class="table-responsive">
          <table class="table  table-bordered">
            <thead>
              <tr>
                 <th> Day </th>
                 <th> Total Slot </th>
              </tr>
            </thead>
            <tbody>
                 @foreach($slot_detail as $item)
                     <tr>
                         <td>{{ $item->week_name }}</td>
                         <td>{{ $item->id_total }}</td>
                     </tr>
                  @endforeach
                    
            </tbody>

          </table>
        </div>
      </div>


    </div>


  </div>
</div>







@endif





@endsection