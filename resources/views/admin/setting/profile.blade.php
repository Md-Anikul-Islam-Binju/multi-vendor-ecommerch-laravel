@extends('layouts.admin-master')
@section('title', 'Profile Update')
@section('css')
    <link href="{{asset('assets')}}/node_modules/dropify/dist/css/dropify.min.css" rel="stylesheet" type="text/css" />
<style type="text/css">
   .dropify-wrapper{
            height: 130px !important;
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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Admin</a></li>
                            <li class="breadcrumb-item active">Profile</li>
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
                    <form action="{{route('admin.profileUpdate')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="title_head">
                                Update Profile
                            </div>
                            
                            <div class="form-group row">
                                <label class="col-md-1 col-form-label" for="name">Name</label>
                                <div class="col-md-6">
                                    <input type="text" value="{{Auth::guard('admin')->user()->name}}" placeholder="Enter name" name="name" required="" id="name" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 col-form-label" for="username">Username</label>
                                <div class="col-md-6">
                                    <input type="text" value="{{Auth::guard('admin')->user()->username}}" placeholder="Enter username" name="username" required="" id="username" class="form-control" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-1 col-form-label" for="mobile">Mobile</label>
                                 <div class="col-md-6">
                                    <input type="text" value="{{Auth::guard('admin')->user()->mobile}}" placeholder="Enter mobile number" name="mobile" required="" id="mobile" class="form-control" >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-1 col-form-label" for="email">Email</label>
                                 <div class="col-md-6">
                                    <input type="text" value="{{Auth::guard('admin')->user()->email}}" placeholder="Enter email number" name="email" required="" id="email" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 col-form-label dropify_image">Profile Image</label>
                                <div class="col-md-3">
                                    <input data-default-file="{{asset('assets/images/users/'.Auth::guard('admin')->user()->photo)}}" type="file" class="dropify" accept="image/*" data-type='image' data-allowed-file-extensions="jpg jpeg png gif"  data-max-file-size="2M"  name="phato" id="input-file-events">
                                </div>
                               
                            </div> 
                          
                            <div class="form-group row">
                                <div class="col-md-7">
                                    <div class="pull-right text-right">
                                        <button type="submit"  name="submit" value="save" class="btn btn-success"> <i class="fa fa-save"></i> Update Profile</button>
                                    </div>
                                </div>
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
@endsection