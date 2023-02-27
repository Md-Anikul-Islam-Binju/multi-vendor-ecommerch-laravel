@extends('layouts.frontend')
@section('title', 'Recover password | '.Config::get('siteSetting.site_name'))
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
    }

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
                        <div class="col-xs-12">
                            <h3 style="text-align: center;">Recover Password</h3>
                            @if(Session::has('status'))
                            <div class="alert alert-success">
                              <strong>Success! </strong> {{Session::get('status')}}
                            </div>
                            @endif
                            @if(Session::has('error'))
                            <div class="alert alert-danger">
                              <strong>Error! </strong> {{Session::get('error')}}
                            </div>
                            @endif
                        </div>
                        @if(Request::get('mobile')) 
                        <form class="form-horizontal" data-parsley-validate  method="get" id="recoverResetform" action="{{ route('password.recoverVerify') }}">
                           
                            <input type="hidden" name="mobile" value="{{Request::get('mobile')}}">
                            <p>Please enter the 4-digit verification code we sent via SMS:</p>
                            <div class="row">
                                <div class="col-xs-8 col-sm-8">
                                    <input class="form-control" value="{{ old('otp_code') }}" name="otp_code" type="text" minlength="4" required placeholder="Enter your OTP Code."> 
                                    @if ($errors->has('otp_code'))
                                        <span class="error" role="alert">
                                           {{ $errors->first('otp_code') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-xs-4 col-sm-4">
                                    <button class="btn btn-primary" type="submit">Verify</button>
                                </div>
                                <div class="col-xs-12" style="line-height: 2">
                                    <span>Didn't receive the code?</span><br/>
                                    <a href="{{ route('password.recover') }}?emailOrMobile={{Request::get('mobile')}}"> Send code again</a><br/>
                                    
                                </div>
                            </div>
                        </form>
                        @else      
                        <form class="form-horizontal" data-parsley-validate method="post" id="recoverResetform" action="{{ route('password.recover') }}">
                            @csrf 
                            <div class="row">      
                                <div class="col-xs-12">
                                    
                                    <p class="text-muted">Enter your Mobile or Email and instructions will be sent to you!</p>
                                    
                                    <input class="form-control" id="emailOrMobile" value="{{ old('emailOrMobile') }}" name="emailOrMobile" type="text" required placeholder="Mobile or Email"> 
                                    @if ($errors->has('emailOrMobile'))
                                        <span class="error" role="alert">
                                           {{ $errors->first('emailOrMobile') }}
                                        </span>
                                    @endif
                                </div>
                                <div class="col-xs-12">
                                    <button style="margin: 20px 0;" class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" id="sendBtn" type="submit">Reset Password </button>
                                </div>
                            </div>
                            </form>
                            @endif
                           
                    </div>
                </div>
            </div>
            <div class="actions-toolbar">
                <div class="col-sm-12 text-center">
                    Back to login <a href="{{route('login')}}" class="text-info m-l-5"><b>Login</b></a>
                </div>
            </div>  
            <div class="col-md-3 col-xs-12"></div>     
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
     $('#sendBtn').click('on', function(){
        var emailOrMobile = $('#emailOrMobile').val();
        if(emailOrMobile){
            $('#sendBtn').html('Sending...');
        }
    });
        
</script>
@endsection
