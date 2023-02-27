@extends('layouts.admin-master')
@section('title', 'Header Setting')
@section('css-top')
  <link href="{{asset('assets')}}/node_modules/jquery-asColorPicker-master/dist/css/asColorPicker.css" rel="stylesheet" type="text/css" />
@endsection
@section('css')
<link href="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />

<link href="{{asset('css')}}/pages/tab-page.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    #HeaderSetting input, #HeaderSetting textarea{color: #797878!important}
    .asColorPicker_open{z-index: 9999999;border:1px solid #ccc;}
</style>
@endsection
@section('content')
        <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                
                <div class="col-md-12 align-self-center ">
                    <div class="d-fl ">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Header</a></li>
                            <li class="breadcrumb-item active">Setting</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <div class="row">
               
                <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="title_head">
                                Header Setting
                            </div>
                               
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"> <a class="nav-link @if(!Session::get('updateTab')) active @endif @if(Session::get('updateTab') == 'HeaderSetting') active @endif" data-toggle="tab" href="#HeaderSetting" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Header Setting</span></a> </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabcontent-border">
                                    
                                    <div class="tab-pane active  p-20" id="headerFooter" role="tabpanel">
                                        <form action="{{route('headerSettingUpdate', $setting->id)}}"  method="post" data-parsley-validate>
                                            @csrf
                                            <div class="form-body">
                                                
                                                <div class="">
                                                        <div class="form-group row">
                                                            <label class="col-md-2 text-right col-form-label" for="header_no">Header No</label>
                                                            <div class="col-md-2">
                                                                <select name="header_no" id="header_no" class="form-control">
                                                                @for($i=1; $i<=10; $i++)
                                                                   <option @if($i == $setting->header_no) selected @endif value="{{$i}}">Header {{$i}}</option>
                                                                @endfor
                                                                </select>
                                                            </div>

                                                            <label class="col-md-1 text-right col-form-label" for="header_no">BG color</label>
                                                            <div class="col-md-2">
                                                                <input name="header_bg_color" value="{{ ($setting->header_bg_color) ? $setting->header_bg_color : '#fff' }}" type="text" value="#fff" class="gradient-colorpicker form-control ">
                                                            </div>

                                                            <label class="col-md-1 text-right col-form-label" for="header_no">Text color</label>
                                                            <div class="col-md-2">
                                                                <input name="header_text_color" value="{{ $setting->header_text_color }}" class="gradient-colorpicker form-control" type="text">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-2 text-right col-form-label" style="background: #fff;top:-10px;z-index: 1" for="Header">Header Text</label>
                                                            <div class="col-md-8">
                                                                <textarea rows="2" name="header" class=" form-control"  id="Header" placeholder="Enter css, meta tags, script etc">{{$setting->header}}</textarea>
                                                            </div>
                                                        </div>
                                                       

                                                        
                                                </div><hr>
                                                <div class="form-actions pull-right">
                                                    <button type="submit"  name="updateTab" value="headerFooter" class="btn btn-success"> <i class="fa fa-save"></i> Update Header Setting</button>
                                                   
                                                    <button type="reset" class="btn waves-effect waves-light btn-secondary">Reset</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->

@endsection

@section('js')


    <!-- Color Picker Plugin JavaScript -->
    <script src="{{asset('assets')}}/node_modules/jquery-asColor/dist/jquery-asColor.js"></script>
    <script src="{{asset('assets')}}/node_modules/jquery-asGradient/dist/jquery-asGradient.js"></script>
    <script src="{{asset('assets')}}/node_modules/jquery-asColorPicker-master/dist/jquery-asColorPicker.min.js"></script>
    
    <script>
  
   
    $(".gradient-colorpicker").asColorPicker({
        mode: 'gradient'
    });
   

    </script>
@endsection