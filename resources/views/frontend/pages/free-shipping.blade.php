@extends('layouts.frontend')
@section('title', $page->title . ' | '. Config::get('siteSetting.site_name') )
@section('css')
    <!-- css custom code here-->
@endsection
@section('content')

    <!-- Main Container  -->
    <div class="breadcrumbs">
        <div class="container">
            
            <ul class="breadcrumb-cate">
                <li><a href="{{url('/')}}"><i class="fa fa-home"></i> </a></li>
                <li>{{$page->title}}</li>
            </ul>
        </div>
    </div>

    <div class="container" style="background: #fff;">
        <div class="row">
            <div id="content" class="col-sm-12">
                
                <div class="about_wrapper">
                   <h3 class="title-page font-ct">Title</h3>
                   <div class="content-page">
                        Description
                   </div>
                </div>
          
            </div>
        </div>
    </div>
 
@endsection

@section('js')
       <!-- javascript custom code here-->
@endsection