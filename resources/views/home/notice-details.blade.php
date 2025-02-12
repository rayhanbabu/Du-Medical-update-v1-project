@extends('layouts/memberheader')
@section('page_title','Diagnostic Dashboard')
@section('notice_details','active')
@section('content')

<div class="container mt-5">
        <div class="card">
        <img src="{{ asset('uploads/admin/'.$data->image) }}" class="card-img-top" alt="Notice Image" style="height: 400px;">
            <div class="card-body">
                <h3 class="card-title"> {{$data->title}} </h3>
                <p class="text-muted">Date: {{$data->date}}</p>
                <p class="card-text">
                   {!!$data->desc!!}
                </p>
               
            </div>
        </div>
    </div>

@endsection