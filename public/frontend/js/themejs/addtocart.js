    // Cart add functions
    function addToCart(product_id, offer=''){
       	var url = window.location.origin;
        $.ajax({
            method:'get',
            url:url +'/cart/add',
            data:{
                product_id:product_id,offer:offer,
            },
            success:function(data){
                if(data.status == 'success'){
                    addProductNotice(data.msg, '<img src="'+url+'/upload/images/product/thumb/'+data.image+'" alt="">', '<h3>'+data.title+'</h3>', 'success');
                    $('.cartCount').html(Number($('.cartCount').html())+1);
                }else{
                    toastr.error(data.msg);
                }
            }
        });
    }   

    // delete cart item
    function deleteCartItem(route) {
        //separate id from route
        var id = route.split("/").pop();
       
        $.ajax({
            url:route,
            method:"get",
            success:function(data){
                if(data){
                    $('#cart_summary').html(data);
                    $('#grandTotal').html(data.grandTtotal);
                    
                    toastr.success('Cart item deleted.');
                }else{
                    toastr.error(data.msg);
                }
            }

        });
    }


    // Cart add functions
    function addToWishlist(product_id){
       
        var url = window.location.origin;
        $.ajax({
            method:'get',
            url:url +'/addto/wishlist',
            data:{
                'product_id':product_id
            },
            success:function(data){
              
                if(data.status == 'success'){
                    toastr.success(data.msg);
                }else{
                    toastr.error(data.msg);
                }
            }
        });
    }  

        // Cart add functions
    function addToCompare(product_id){
        var url = window.location.origin;
        $.ajax({
            method:'get',
            url:url +'/addto/compare/'+product_id,
            data:{
                product_id:product_id,
            },
            success:function(data){
              
                if(data.status == 'success'){
                     toastr.success(data.msg);
                }else{
                    toastr.error(data.msg);
                }
            }
        });
    } 


	/* ---------------------------------------------------
		jGrowl – jQuery alerts and message box
	-------------------------------------------------- */
	function addProductNotice(title, thumb, text, type) {
		$.jGrowl.defaults.closer = false;
		//Stop jGrowl
		//$.jGrowl.defaults.sticky = true;
		var tpl = thumb + '<h3>'+text+'</h3>';
		$.jGrowl(tpl, {		
			life: 4000,
			header: title,
			speed: 'slow',
			theme: type
		});
	}

