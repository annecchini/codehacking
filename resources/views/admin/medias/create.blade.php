@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css">
@stop

@section('content')
<h1>Create Media</h1>

{!! Form::open(['method'=>'POST', 'action'=>'AdminMediasController@store','class'=>'dropzone', 'files'=>true]) !!}


{!! Form::close() !!}

@include('includes.form_error')

@stop

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>
@stop