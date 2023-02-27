@extends('layouts.admin-master')
@section('title', 'Withdraw Configuration ')
@section('css')

@endsection
@section('content')
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor"><a href="{{ url()->previous() }}"> <i class="fa fa-angle-left"></i> Withdraw Configuration</a></h4>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="container">
                       
                        <div class="col-md-12">
                            <div class="card card-body">
                               
                                <form action="{{ route('siteSettingUpdate') }}" method="post" >
                                    @csrf
                                    <input type="hidden" name="type" value="customer_withdraw_configure">
                                    <div class="form-group">
                                        <label class="required" for="title">Set Withdraw Commission(%)</label><br/>
                                        <input style="width: 300px" required="" name="value" min="0" id="title" value="{{ $withdraw->value }}" type="number" placeholder="Example 10%" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label class="required" for="title">Minimum Withdraw Amount</label><br/>
                                        <input style="width: 300px" required="" name="value2" min="1" id="title" value="{{ $withdraw->value2 }}" type="number" placeholder="Example {{config('siteSetting.currency_symble')}}50 " class="form-control">
                                    </div>

                                    <div class="form-group">
                                       <p class="switch-box">Withdraw Request Status </p>
                                        
                                        <label for="active"> <input type="radio" name="status" value="1"  {{ ($withdraw->status == '1') ? 'checked' : '' }} id="active">
                                        Active</label> 
                                        <label for="DeActive"> <input type="radio" name="status" value="0"  {{ ($withdraw->status == '0') ? 'checked' : '' }} id="DeActive">
                                        DeActive</label>
                                        
                                    </div>
                                    <button type="submit" class="btn btn-info">Update</button>
                                </form>
                                   
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
           
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
@endsection

@section('js')


    <script type="text/javascript">
        //change status by id
        function siteSettingActiveDeactive(field){
            var  url = '{{route("siteSettingActiveDeactive")}}';
            $.ajax({
                url:url,
                method:"get",
                data:{field:field},
                success:function(data){
                    if(data.status){
                        toastr.success(data.message);
                    }else{
                        toastr.error(data.message);
                    }
                }
            });
        }
    </script>  
@endsection