@extends('layouts.admin-master')
@section('title', 'General Setting')
@section('css')
<link href="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
<link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    #generalSetting input, #generalSetting textarea{color: #797878!important}

    .dropify-wrapper{
            width: 300px !important;
            height: 150px !important;
        }
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">General</a></li>
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

            <div class="card">
                <div class="card-body">
                    <form action="{{route('generalSettingUpdate', $setting->id)}}" enctype="multipart/form-data" method="post" id="generalSetting">
                        @csrf
                       
                        <div class="form-body">
                            <div class="title_head">
                                General Setting
                            </div>
                            <div class="">
                               
                                    <div class="form-group row">
                                        <label class="col-md-2 text-right col-form-label" for="site_name">Site Name</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{$setting->site_name}}" placeholder="Enter site name" name="site_name" required="" id="site_name" class="form-control" >
                                        </div>
                                    </div>
                               
                                    <div class="form-group row">
                                        <label class="col-md-2 text-right col-form-label" for="phone">Phone</label>
                                         <div class="col-md-8">
                                            <input type="text" value="{{$setting->phone}}" placeholder="Enter phone number" name="phone" required="" id="phone" class="form-control" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 text-right col-form-label" for="email">Email</label>
                                         <div class="col-md-8">
                                            <input type="text" value="{{$setting->email}}" placeholder="Enter email number" name="email" required="" id="email" class="form-control" >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2 text-right col-form-label" style="background: #fff;top:-10px;z-index: 1" for="about">About</label>
                                        <div class="col-md-8">
                                            <textarea  rows="3"  name="about" class=" form-control" id="about" rows="5">{{$setting->about}}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2 text-right col-form-label" style="background: #fff;top:-10px;z-index: 1" for="address">Address</label>
                                        <div class="col-md-8">
                                            <textarea  rows="3"  name="address" class=" form-control" id="address" rows="5">{{$setting->address}}</textarea>
                                        </div>
                                    </div>
                                
                                    <div class="form-group row">
                                        <label class="col-md-2 text-right col-form-label" style="background: #fff;top:-10px;z-index: 1" for="Header">Header Text</label>
                                        <div class="col-md-8">
                                            <textarea rows="3" name="header_text" class=" form-control" rows="5" id="Header" placeholder="Enter css, meta tags, script etc">{{$setting->header}}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2 text-right col-form-label" style="background: #fff;top:-10px;z-index: 1" for="footer">Footer Text</label>
                                        <div class="col-md-8">
                                            <textarea rows="3" class="form-control" rows="3" name="footer" id="footer" placeholder="Enter js script, etc code">{{$setting->footer}}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2 text-right col-form-label" for="header_no">Header</label>
                                        <div class="col-md-3">
                                            <select name="header_no" id="header_no" class="form-control">
                                            @for($i=1; $i<=10; $i++)
                                               <option @if($i == $setting->header_no) selected @endif value="{{$i}}">Header {{$i}}</option>
                                            @endfor
                                            </select>
                                        </div>
                                        <label class="col-md-2 text-right col-form-label" for="footer_no">Footer</label>
                                         <div class="col-md-3">
                                            <select  name="footer_no" id="footer_no" class="form-control">
                                            @for($i=1; $i<=10; $i++)
                                               <option @if($i == $setting->footer_no) selected @endif value="{{$i}}">Footer {{$i}}</option>
                                            @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 text-right col-form-label" for="currency">Currency</label>
                                        <div class="col-md-3">
                                            <input type="text" value="{{$setting->currency}}" placeholder="Enter page name" name="currency" required="" id="currency" class="form-control" >
                                        </div>
                                        <label class="col-md-2 text-right col-form-label" for="currency_symble">Currency Symble</label>
                                         <div class="col-md-3">
                                            <input type="text" value="{{$setting->currency_symble}}" placeholder="Enter page name" name="currency_symble" required="" id="currency_symble" class="form-control" >
                                        </div>
                                    </div>
                              

                                    <div class="form-group row">
                                        <label class="col-md-2 text-right col-form-label" for="date_format">Date Format</label>
                                        <div class="col-md-8">
                                            <select class="form-control custom-select" name="date_format" id="date_format" required="required">
                                                <option value="{{$setting->date_format}}">{{Carbon\Carbon::parse(now())->format($setting->date_format)}}</option>
                                                 <option value="Y-m-d">{{Carbon\Carbon::parse(now())->format('Y-m-d')}}</option>
                                                    <option value="d-m-Y">{{Carbon\Carbon::parse(now())->format('d-m-Y')}}</option>
                                                    <option value="d/m/Y">{{Carbon\Carbon::parse(now())->format('d/m/Y')}} </option>
                                                    <option value="m/d/Y">{{Carbon\Carbon::parse(now())->format('m/d/Y')}} </option>
                                                    <option value="m.d.Y">{{Carbon\Carbon::parse(now())->format('m.d.Y')}} </option>
                                                    <option value="j, n, Y">{{Carbon\Carbon::parse(now())->format('j, n, Y')}} </option>
                                                    <option value="F j, Y">{{Carbon\Carbon::parse(now())->format('F j, Y')}} </option>
                                                    <option value="M j, Y" selected="selected">{{Carbon\Carbon::parse(now())->format('M j, Y')}}</option>
                                                    <option value="j M, Y">{{Carbon\Carbon::parse(now())->format('j M, Y')}}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-2 text-right col-form-label" for="title">Meta Title</label>
                                        <div class="col-md-8">
                                            <input type="text" value="{{$setting->title}}"  name="title" id="title" placeholder = 'Enter meta title'class="form-control" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 text-right col-form-label">Meta Keywords</label>
                                        <div class="col-md-8">
                                             <div class="tags-default">
                                               
                                                <input style="width: 100%" type="text" name="meta_keywords[]"  data-role="tagsinput" value="{{$setting->meta_keywords}}" placeholder="Enter meta keywords" />
                                                 <p style="font-size: 12px;color: #777;font-weight: initial;">Write meta tags Separated by Comma[,]</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-2 text-right col-form-label" for="description">Meta Description</label>
                                        <div class="col-md-8">
                                            <textarea class="form-control" name="description" id="description" rows="2" style="resize: vertical;" placeholder="Enter Meta Description">{{$setting->description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                    
                                        <label class="col-md-2 text-right col-form-label">Meta image</label>
                                        <div class="col-md-8">
                                            <input type="file" data-default-file="{{asset('upload/images/'.$setting->meta_image)}}" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpeg jpg png gif" name="meta_image" id="input-file-events">
                                        </div>
                                    </div>
                            </div><hr>
                            <div class="form-actions pull-right">
                                <button type="submit"  name="submit" value="save" class="btn btn-success"> <i class="fa fa-save"></i> Update Setting</button>
                               
                                <button type="reset" class="btn waves-effect waves-light btn-secondary">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
               
            </div>

        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->

@endsection

@section('js')
<script src="{{asset('assets')}}/node_modules/dropify/dist/js/dropify.min.js"></script>
     <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
    });
</script>
    <script src="{{asset('assets')}}/node_modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script type="text/javascript">
    // Enter form submit preventDefault for tags
    $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
      if(e.keyCode == 13) {
        e.preventDefault();
        return false;
      }
    });
    </script>
@endsection