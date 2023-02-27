@extends('layouts.admin-master')
@section('title', 'Change Password')

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
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Password</a></li>
                            <li class="breadcrumb-item active">Change</li>
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
                    <form action="{{route('admin.passwordChange')}}" data-parsley-validate  method="post">
                        @csrf
                        <div class="form-body">
                            <div class="title_head">
                                Change Password
                            </div>
                            
                    
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" for="username">Old Password</label>
                                <div class="col-md-6">
                                   <input type="password" required class="form-control"  placeholder="Old Password" value="" name="old_password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" for="mobile">New Password</label>
                                 <div class="col-md-6">
                                    <input type="password" required class="form-control" minlength="6" id="password" placeholder="New Password" value="" name="password">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" for="email">New Password Confirm</label>
                                 <div class="col-md-6">
                                    <input type="password" class="form-control" id="input-confirm"  data-parsley-equalto="#password" required="" placeholder="New Password Confirm" value="" name="password_confirmation">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-7">
                                    <div class="pull-right text-right">
                                        <button type="submit"  name="submit" value="save" class="btn btn-success"> <i class="fa fa-save"></i> Change Password</button>
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
