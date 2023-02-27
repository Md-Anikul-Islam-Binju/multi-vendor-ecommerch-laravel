    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/custom.min.js') }}"></script>
  
    @yield('js')
    @yield('perpage-js')
    <script type="text/javascript">
        //change status by id
        function satusActiveDeactive(table, id, field = null){
            @if(env('MODE') == 'demo')
            toastr.error('Demo mode on edit/update not working');
            return false;
            @endif
            var  url = '{{route("statusChange")}}';
            $.ajax({
                url:url,
                method:"get",
                data:{table:table,field:field,id:id},
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

    <script type="text/javascript">
      
        function deleteConfirmPopup(route, item='') {
            $('#deleteModal').modal('show');
            document.getElementById('deleteItemRoute').value = route;
            //hide delete item
            document.getElementById('item').value = item;
        }

        function deleteItem(route) {
            @if(env('MODE') == 'demo')
            toastr.error('Demo mode on delete not working');
            return false;
            @endif
            //separate id from route
            var id = route.split("/").pop();
            var item = $('#item').val();
            $.ajax({
                url:route,
                method:"get",
                success:function(data){
                    if(data.status){
                        $("#item"+item+id).hide();
                        toastr.success(data.msg);
                    }else{
                        toastr.error(data.msg);
                    }
                }
            });
        }

        // delete product feature detail
        function deleteDataCommon(table,id, field=''){
            @if(env('MODE') == 'demo')
            toastr.error('Demo mode on delete not working');
            return false;
            @endif
            if(confirm('Are you sure delete.?')) {
                var route = '{{ route("deleteDataCommon") }}';
                route = route.replace(":id", id);
                $.ajax({
                    url:route,
                    method:"get",
                    data:{table:table,id:id,field:field},
                    success:function(data){
                        if(data.status){
                            $("#"+table+id).remove();
                            toastr.success(data.msg);
                        }else{
                            toastr.error(data.msg);
                        }
                    }
                });
            }else{
                return false;
            }
        }
    </script>    

    <script type="text/javascript">
        //change status by id
        function approveUnapprove(table, id, field = null){
            @if(env('MODE') == 'demo')
            toastr.error('Demo mode on edit/update not working');
            return false;
            @endif
            var  url = '{{route("approveUnapprove")}}';
            $.ajax({
                url:url,
                method:"get",
                data:{table:table,field:field,id:id},
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

    {!! Toastr::message() !!}
    <script>
        @if($errors->any())
            
            @if(Session::get('submitType'))
                // if occur error open model
                $("#{{Session::get('submitType')}}").modal('show');
                //open edit modal by id
                @if(Session::get('submitType')=='edit')
                    edit({{old('id')}});
                @endif
            @endif

            @foreach($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>

    <script>
        $(document).ready(function(){
            $( "#positionSorting" ).sortable({
                placeholder : "ui-state-highlight",
                update  : function(event, ui)
                {
                    var ids = new Array();
                    $('#positionSorting tr').each(function(){
                        ids.push($(this).attr("id"));
                    });
                    var table = $(this).attr('data-table');

                    $.ajax({
                        url:"{{route('positionSorting')}}",
                        method:"get",
                        data:{ids:ids,table:table},
                        success:function(data){
                            toastr.success(data)
                        }
                    });
                }
            });
        });
    </script>
    <script type="text/javascript" src="{{asset('js')}}/shortcuts.js"></script>
    <script>
    shortcuts.add('alt+u',function() {
        window.location = "{{url('/')}}/admin/product/upload" 
    })
    shortcuts.add('alt+o',function() {
        window.location = "{{url('/')}}/admin/order" 
    })
    shortcuts.add('alt+d',function() {
        window.location = "{{url('/')}}/admin" 
    })
    shortcuts.add('alt+h',function() {
        window.location = "{{url('/')}}/admin/homepage/section" 
    })
    shortcuts.add('alt+w',function() {
        window.location = "{{url('/')}}" 
    })
    shortcuts.add('alt+s',function() {
        window.location = "{{url('/')}}/admin/slider/create" 
    })
    shortcuts.add('alt+c',function() {
        window.location = "{{url('/')}}/admin/customer/list" 
    })
    shortcuts.add('alt+r',function() {
        window.location = "{{url('/')}}/admin/product/review" 
    })
    shortcuts.add('alt+b',function() {
        window.location = "{{url('/')}}/admin/banner/list" 
    })
    shortcuts.add('alt+g',function() {
        window.location = "{{url('/')}}/admin/general/setting" 
    })
    shortcuts.add('alt+l',function() {
        window.location = "{{url('/')}}/admin/logo/setting" 
    })
    shortcuts.add('alt+p',function() {
        window.location = "{{url('/')}}/admin/product" 
    })
    </script>
<!--     <script>
        
        Echo.channel('postBroadcast')
        .listen('PostCreated', (e) => {
            toastr.info(e.post['title']);
        });
    </script> -->