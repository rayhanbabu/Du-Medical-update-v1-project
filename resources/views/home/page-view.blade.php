@extends('layouts/memberheader')
@section('page_title','Doctor Dashboard')
@section('diagnostic_test','active')
@section('content')

  <div class="container my-4 border shadow">
    <h2 class="text-center my-3"> {{$data->title}} </h2>
    <hr>
    <div class="row">
     
      {!! $data->desc !!}
    
  
    </div>
  </div>


@endsection