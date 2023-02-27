@extends('layouts.frontend')
@section('title', 'Offer not eligible')
@section('css')
    <link rel="stylesheet" href="{{asset('css/pages/error-pages.css')}}">
@endsection
@section('content')
    <section id="wrapper" style="background: #fafcf9">
        <div  style="padding: 15px 0; position: relative !important;">
            <div class="text-center">
                <img src="{{ asset('upload/images/offer/offerimoji.gif') }}" width="200">
                <h3 class="text-uppercase" style="text-transform: inherit;">Sorry You Aren't Eligible For This Offer.!</h3>
                <p class="text-muted m-t-10 m-b-30">Stay with Woadi and wait for the next campaign.</p>
                <a href="{{url('/')}}" class="btn btn-info btn-rounded waves-effect waves-light m-b-40">Back to home</a> 
            </div>
        </div>
    </section>
@endsection