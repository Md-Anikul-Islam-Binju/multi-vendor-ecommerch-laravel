@extends('layouts.frontend')
@section('title', 'Reseller Register  | '.Config::get('siteSetting.site_name'))
@section('css-top')
    <link href="{{asset('css/pages/login-register-lock.css')}}" rel="stylesheet">
    <link href="{{asset('assets')}}/node_modules/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
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
        .form-control{box-shadow: none !important;}
        label{margin-bottom: 0;}
        .error{color:red;}
        .registerArea{background: #fff; color:#000; border-radius: 5px;margin:10px 0;padding: 10px !important ;}
        .registerArea label{margin: 0}
        .registerArea .form-group{margin-bottom: 0}
    </style>
@endsection
@section('content')
    <section>
    <div class="container">
        
        <div class="row justify-content-md-center" >
           <div class="col-md-3 col-12 hidden-xs hidden-sm" ></div>
            <div class="col-md-6 col-12 registerArea" >
                <div class="card">

                   <div class="card-body">
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
                        <form data-parsley-validate action="{{route('resellerRegister')}}" method="post" >
                            @csrf
                            <div class="card-header text-center"><h3>Reseller Sign Up</h3></div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                   
                                    <div class="form-group">
                                      <label class="control-label required" for="shop_name">Shop Name</label>
                                      <input type="text" required name="shop_name" value="{{old('shop_name')}}" placeholder="Enter Your Shop Name" data-parsley-required-message = "Shop name is required" id="shop_name" class="form-control">
                                      @if ($errors->has('name'))
                                            <span class="error" role="alert">
                                                {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                      <label class="control-label required" for="vendor_name">Seller Name</label>
                                      <input type="text" required name="vendor_name" value="{{old('vendor_name')}}" placeholder="Enter Your Name" data-parsley-required-message = "Name is required" id="vendor_name" class="form-control">
                                        @if ($errors->has('vendor_name'))
                                            <span class="error" role="alert">
                                                {{ $errors->first('vendor_name') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                           
                                <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="control-label required" for="mobile">Mobile Number</label>
                                      <input type="mobile" pattern="/(01)\d{9}/" required name="mobile" value="{{old('mobile')}}" onkeyup ="checkField(this.value, 'mobile')" placeholder="Enter Mobile Number" data-parsley-required-message = "Mobile number is required" class="form-control">
                                      <span id="mobile"></span>
                                        @if ($errors->has('mobile'))
                                            <span class="error" role="alert">
                                                {{ $errors->first('mobile') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="control-label" for="email">Email Address</label>
                                      <input type="email" name="email" value="{{old('email')}}" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-zA-Z]{2,4}" placeholder="Enter Email Address" id="email" class="form-control">
                                      @if ($errors->has('email'))
                                            <span class="error" role="alert">
                                                {{ $errors->first('email') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            
                                
                            
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <span class="required">Address</span>
                                        <input type="text" required data-parsley-required-message = "Address is required" value="{{old('address')}}" name="address" placeholder="Enter Address" class="form-control">
                                    </div>
                                </div>




                                <div class="col-md-12">
                                    <div class="form-group">
                                        <span class="required">Website / Facebook link Address</span>
                                        <input type="text" value="{{old('link_address')}}" name="link_address" placeholder="https://facebook.com/shop_name" class="form-control">
                                    </div>
                                </div>







                            
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required" for="password">Password</label>
                                        <input type="password" value="{{old('password')}}" name="password" placeholder="Password" required id="password" data-parsley-required-message = "Password is required" minlength="6"  class="form-control">
                                        @if ($errors->has('password'))
                                            <span class="error" role="alert">
                                               {{ $errors->first('password') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label required" for="password">Confirm Password</label>
                                       <input type="password" placeholder="Retype password" data-parsley-equalto="#password" required="" value="{{old('password_confirmation')}}" name="password_confirmation" id="password2"  class="form-control">
                                        @if ($errors->has('password_confirmation'))
                                            <span class="error" role="alert">
                                               {{ $errors->first('password_confirmation') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            
                                <div class="col-md-12">
                                    <div style=" display: flex!important;" class="d-flex no-block align-items-center">
                                        <div style="display: inline-flex;" class="custom-control custom-checkbox">
                                            <input type="checkbox" data-parsley-required-message = "Terms & Conditions  is required" class="custom-control-input" id="agree" required> 
                                            <label style="margin: 0 5px;" class="custom-control-label" for="agree"> I've read and understood <a href="{{url('seller-policy')}}/" style="color: blue">Terms & Conditions </a></label>
                                        </div> 
                                        
                                    </div>
                                </div>
                        
                                <div class="form-group text-center">
                                    <div class="col-xs-12 p-b-20">
                                        <button id="submitBtn" class="btn btn-block btn-lg btn-info btn-rounded" type="submit">Sign Up</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="form-group m-t-20">
                    <div class="col-sm-12 text-center">
                        Already have an account?  <a href="{{route('resellerLoginForm')}}" class="text-info m-l-5"><b>Sign In</b></a>
                    </div>
                </div>   
                <div class="col-md-3 col-12"></div>     
            </div>
        </div>
    </div>
    </section>
@endsection

@section('js')
    <script src="{{asset('assets')}}/node_modules/select2/dist/js/select2.full.min.js" type="text/javascript"></script>

    <script type="text/javascript">
       
        @if(Session::has('state')) 
            get_city("{{Session::get('state')}}");
        @endif

        function get_city(id){
         
            var  url = '{{route("get_city", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#city").html(data);
                        $(".select2").select2();
                        $("#city").focus();
                    }else{
                        $("#city").html('<option>City not found</option>');
                    }
                }
            });
        }    

        @if(Session::has('city')) 
            get_area("{{Session::get('city')}}");
        @endif

        function get_area(id){
               
            var  url = '{{route("get_area", ":id")}}';
            url = url.replace(':id',id);
            $.ajax({
                url:url,
                method:"get",
                success:function(data){
                    if(data){
                        $("#area").html(data);
                        $(".select2").select2();
                        $("#area").focus();
                    }else{
                        $("#area").html('<option>Area not found</option>');
                    }
                }
            });
        }  

    </script>

    <script type="text/javascript">
        function checkField(value, field){
            if(value != ""){
                $.ajax({
                    method:'get',
                    url:"{{ route('checkField') }}",
                    data:{table:'vendors', field:field, value:value},
                    success:function(data){
                        
                        if(data.status){
                            $('#'+field).html("<span style='color:green'><i class='fa fa-check'></i> "+data.msg+"</span>");
                            
                            $('#submitBtn').removeAttr('disabled');
                            $('#submitBtn').removeAttr('style', 'cursor:not-allowed');
                            
                        }else{
                            $('#'+field).html("<span style='color:red'><i class='fa fa-times'></i> "+data.msg+"</span>");
                            
                            $('#submitBtn').attr('disabled', 'disabled');
                            $('#submitBtn').attr('style', 'cursor:not-allowed');
                            
                        }
                    },
                    error: function(jqXHR, exception) {
                        toastr.error('Unexpected error occur.');
                    }
                });
            }else{
                $('#'+field).html("<span style='color:red'>"+field +" is required</span>");
                
                $('#submitBtn').attr('disabled', 'disabled');
                $('#submitBtn').attr('style', 'cursor:not-allowed');
                
            }
        }
   
    $(".select2").select2();

    </script>
@endsection


