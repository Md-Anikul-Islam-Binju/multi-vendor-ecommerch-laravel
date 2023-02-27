@extends('layouts.frontend')
@section('title', 'Login | '.Config::get('siteSetting.site_name'))
@section('css-top')

<style type="text/css">
    @media (min-width: 1200px){
        .container {
            max-width: 1200px !important;
        }
    }
    .dropdown-toggle::after, .dropup .dropdown-toggle::after {
        content: initial !important;
    }
    .card-footer, .card-header {
        margin-bottom: 5px;
        border-bottom: 1px solid #ececec;
    }#recoverform {
      display: none; }

    .loginArea{background: #fff; border-radius: 5px;margin:10px 0;padding: 20px;}
</style>
 @endsection
@section('content')
<div class="container">
    <div id="pageLoading" style="display: none;"></div>
    <div class="row justify-content-center">
        <div class="col-md-3 col-xs-12"></div>
        <div class="col-md-6 col-xs-12 ">
            <div class="card loginArea">
                <div class="card-body">
                    <div id="loginform">
                        <form action="{{route('vendorLogin')}}" data-parsley-validate method="post">
                            @csrf
                            <div class="card-header text-center"><h3>Seller Login</h3></div>
                            @if(Session::has('success'))
                            <div class="alert alert-success">
                              <strong>Success! </strong> {{Session::get('success')}}
                            </div>
                            @endif
                            @if(Session::has('error'))
                            <div class="alert alert-danger">
                              <strong>Error! </strong> {{Session::get('error')}}
                            </div>
                            @endif
                            <div class="form-group">
                                <label class="control-label" for="emailOrMobile">Email or Mobile Number</label>
                                <input type="text" name="emailOrMobile" value="{{old('emailOrMobile')}}" placeholder="Enter Email or Mobile Number " id="input-email" required="" data-parsley-required-message = "Email or Mobile number is required" class="form-control">
                                @if ($errors->has('emailOrMobile'))
                                    <span class="error" role="alert">
                                        {{ $errors->first('emailOrMobile') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="input-password">Password</label>
                                <input type="password" value="{{old('password')}}" required="" name="password" value="" placeholder="Password" id="input-password" data-parsley-required-message = "Password is required"  class="form-control">
                                @if ($errors->has('password'))
                                    <span class="error" role="alert">
                                       {{ $errors->first('password') }}
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div style=" display: flex!important;" class="d-flex no-block align-items-center">
                                        <div style="display: inline-flex;" class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="Remember"> 
                                            <label style="margin: 0 5px;" class="custom-control-label" for="Remember"> Remember me</label>
                                        </div> 
                                        <div class="ml-auto" style="margin-left: auto!important;">
                                            <a href="javascript:void(0)" id="to-recover" class="text-muted"><i class="fa fa-lock"></i> Forgot pwd?</a> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                            <div class="form-group text-center">
                                <input type="submit" value="Log In" class="btn btn-block btn-lg btn-info btn-rounded">
                            </div> 
                            <div class="form-group m-b-0">
                                <div class="col-sm-12 text-center">
                                    Don't have an account? <a href="{{route('vendorRegisterForm')}}" class="text-info m-l-5"><b>Sign Up</b></a>
                                </div>
                            </div> 
                        </form>
                    </div>  
                    <form class="form-horizontal" method="post" id="recoverform" action="{{ route('seller.password.recover') }}">
                        @csrf
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <h3>Recover Password</h3>
                                <p class="text-muted">Enter your Mobile or Email and instructions will be sent to you!</p>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" id="reseField" name="emailOrMobile" type="text" required placeholder="Mobile or Email"> 
                                @if ($errors->has('emailOrMobile'))
                                <span class="error" role="alert">
                                   {{ $errors->first('emailOrMobile') }}
                                </span>
                            @endif
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" id="resetBtn" type="submit">Reset Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3 col-xs-12"></div>     
        </div>
    </div>
</div>
@endsection

@section('js')
    <!--Custom JavaScript -->
    <script type="text/javascript">
       
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });  

        $('#socialloginBtn').on("click", function() {
           
            document.getElementById('pageLoading').style.display = 'block';
        });

        $('#resetBtn').click('on', function(){
            var reseField = $('#reseField').val();
            if(reseField){
                $('#resetBtn').html('Sending...');
            }
        });
    </script>
@endsection
