@extends('layouts.frontend')
@section('title', 'Recover password | '.Config::get('siteSetting.site_name'))
@section('css-top')

<style type="text/css">

    .hidden_clip {
  clip: rect(1px 1px 1px 1px); // IE6, IE7
  clip: rect(1px, 1px, 1px, 1px);
  position: absolute;
}
.form__field__wrapper {
  position: relative;
}
.show-hide-password {
  background: 0;
  border: 0;
  cursor: pointer;
  min-height: 60px;
  min-width: 70px;
  padding: 18px;
  position: absolute;
  right: 0;
  top: 14px;
}
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
                <form method="POST" data-parsley-validate action="{{ route('reseller.password.recoverUpdate') }}">
                        @csrf
                        @if(Request::get('mobile'))
                        <input type="hidden" name="otp_code" value="{{ Request::get('otp_code') }}">
                        <input type="hidden" name="mobile" value="{{ Request::get('mobile') }}">
                        @endif
                        @if(Request::get('email'))
                        <input type="hidden" name="token" value="{{ Request::get('token') }}">
                        <input type="hidden" name="email" value="{{ Request::get('email') }}">

                        @endif
                      <fieldset class="form__change-password">
                        <legend class="form__legend">
                         <h3 style="text-align: center;">Recover Password</h3>
                        </legend>
                          
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
                        <div class="form__field__wrapper form-item">

                          <label for="edit-old-pass" class="text-input__label--floated">{{ __('New Password') }}</label>

                          <input class="form-control form-text password__field text-input__field--floated required" placeholder="Enter new password" type="password" id="edit-old-pass" name="password" size="60" minlength="6">

                          <div class="show-hide-password js-showHidePassword">
                             <span class="hidden_clip">click this button to show or hide the password</span>
                            <span aria-hidden="true">Show</span>
                          </div>

                        </div>
                        <div class="form__field__wrapper form-item">
                          <label for="edit-new-pass" class="text-input__label--floated">{{ __('Confirm Password') }}<span class="form-required" aria-hidden="true" title="This field is required."></span></label>
                          <input class="form-control form-text password__field text-input__field--floated required" type="password" id="edit-new-pass" data-parsley-equalto="#edit-old-pass" placeholder="Retype password"  name="password_confirmation" minlength="6" aria-required="true">
                          <div class="show-hide-password js-showHidePassword" tabindex="0">
                             <span class="hidden_clip">click this button to show or hide the password</span>
                            <span aria-hidden="true">Show</span>
                          </div>

                        </div>
                      </fieldset>
                      <div class="row " style="margin-top: 15px;">
                          <div class="col-md-6 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  {{ __('Reset Password') }}
                              </button>
                          </div>
                      </div>
                    </form>
                </div>
                <div class="actions-toolbar">
                <div class="col-sm-12 text-center">
                    Back to login <a href="{{route('vendorLoginForm')}}" class="text-info m-l-5"><b>Login</b></a>
                </div>
            </div> 
            </div>
             
            <div class="col-md-3 col-xs-12"></div>     
    </div>
</div>
@endsection

@section('js')

<script type="text/javascript">
    
    function showHidePasswordfn() {
  // The last span inside the button
  var showHideBtn = $(this);

  var showHideSpan = showHideBtn.children().next();
  var $pwd = showHideBtn.prev('input');

  // Toggle a classe called toggleShowHide to thee button
  $(showHideBtn).toggleClass('toggleShowHide');
  // If the button has the class toggleShowHide change the text of the last span inside it
  showHideSpan.text(showHideBtn.is('.toggleShowHide') ? 'Hide' : 'Show');

  if ($pwd.attr('type') === 'password') {
    $pwd.attr('type', 'text');
  } else {
    $pwd.attr('type', 'password');
  }
}

// On Click
$('.js-showHidePassword').on('click', showHidePasswordfn);

// On Enter Key
$('.js-showHidePassword').keypress(function(e) {
  // the enter key code
  if (e.which === keyCodes.enter) {
    showHidePasswordfn();
  }
});
</script>
@endsection



