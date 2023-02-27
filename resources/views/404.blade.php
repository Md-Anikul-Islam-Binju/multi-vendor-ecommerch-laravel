@extends('layouts.frontend')
@section('title', '404 page not found')
@section('css')
    <link rel="stylesheet" href="{{asset('css/pages/error-pages.css')}}">
@endsection
@section('content')
   
    <section id="wrapper" class="error-page">
        <div class="error-box" style="position: relative !important;">
            <div class="error-body text-center">
               
                <h3 class="text-uppercase">Page Not Found !</h3>
                <p class="text-muted m-t-30 m-b-30">YOU SEEM TO BE TRYING TO FIND HIS WAY HOME</p>
                <a href="{{url('/')}}" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to home</a> </div>
            
        </div>
    </section>
@endsection