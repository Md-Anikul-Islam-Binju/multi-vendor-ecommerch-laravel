@extends('layouts.admin-master')
@section('title', 'footer Setting')
@section('css-top')
  <link href="{{asset('assets')}}/node_modules/jquery-asColorPicker-master/dist/css/asColorPicker.css" rel="stylesheet" type="text/css" />
@endsection
@section('css')

<link href="{{asset('css')}}/pages/tab-page.css" rel="stylesheet" type="text/css" />
<style type="text/css">
    #footerSetting input, #footerSetting textarea{color: #797878!important}
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">footer</a></li>
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
                                Footer Setting
                            </div>
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#footerSetting" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Footer Setting</span></a> </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content tabcontent-border">
                                    
                                    <div class="tab-pane active  p-20" id="footerFooter" role="tabpanel">
                                        <form action="{{route('footerSettingUpdate', $setting->id)}}"  method="post" data-parsley-validate id="footerFooter">
                                            @csrf
                                            <div class="form-body">
                                                
                                                <div class="">
                                                        
                                                        
                                                        <div class="form-group row">
                                                            <label class="col-md-2 text-right col-form-label" for="footer_no">Footer No</label>
                                                             <div class="col-md-2">
                                                                <select  name="footer_no" id="footer_no" class="form-control">
                                                                @for($i=1; $i<=10; $i++)
                                                                   <option @if($i == $setting->footer_no) selected @endif value="{{$i}}">Footer {{$i}}</option>
                                                                @endfor
                                                                </select>
                                                            </div>
                                                            <label class="col-md-1 text-right col-form-label" for="footer_no">BG color</label>
                                                            <div class="col-md-2">
                                                                <input name="footer_bg_color" type="text" value="{{($setting->footer_bg_color) ? $setting->footer_bg_color : '#fff' }}" class="gradient-colorpicker form-control ">
                                                            </div>

                                                            <label class="col-md-1 text-right col-form-label" for="footer_no">Text color</label>
                                                            <div class="col-md-2">
                                                                <input name="footer_text_color" value="{{ $setting->footer_text_color }}" class="gradient-colorpicker form-control" type="text">
                                                            </div>
                                                        </div>
                                                        


                                                        <div class="form-group row">
                                                            <label class="col-md-2 text-right col-form-label" style="background: #fff;top:-10px;z-index: 1" for="footer">Footer Text</label>
                                                            <div class="col-md-8">
                                                                <textarea rows="2" class="form-control"  name="footer" id="footer" placeholder="Enter js script, etc code">{!! $setting->footer !!}</textarea>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group row">
                                                            <label class="col-md-2 text-right col-form-label" for="copyright_text">Copyright text</label>
                                                            <div class="col-md-8">
                                                                <textarea rows="1" type="text" name="copyright_text" placeholder="{{ 'Copyright © '. $_SERVER['SERVER_NAME'] .' '.date('Y') }}" class="form-control" id="copyright_text" >{!! $setting->copyright_text !!}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-2 text-right col-form-label" >Copyright BG color</label>
                                                            <div class="col-md-3">
                                                                <input name="copyright_bg_color" value="{{($setting->copyright_bg_color) ? $setting->copyright_bg_color : '#fff' }}" type="text"  class="gradient-colorpicker form-control ">
                                                            </div>

                                                            <label class="col-md-2 text-right col-form-label">Copyright Text color</label>
                                                            <div class="col-md-3">
                                                                <input name="copyright_text_color" value="{{ $setting->copyright_text_color }}" class="gradient-colorpicker form-control" type="text">
                                                            </div>
                                                        </div>
                                                       
                                                </div><hr>
                                                <div class="form-actions pull-right">
                                                    <button type="submit"  name="updateTab" value="footerFooter" class="btn btn-success"> <i class="fa fa-save"></i> Update Setting</button>
                                                   
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