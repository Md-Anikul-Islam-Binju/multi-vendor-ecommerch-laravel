<figure>
  <img class="wm-img fsdf sdf" src="{{asset('upload/images/product/'.$path)}}" alt="anas rar" />
 
</figure>
<script type="text/javascript" src="{{asset('frontend/js')}}/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="{{asset('frontend/js')}}/jquery.watermark.min.js"></script>
<script>
  $(function(){
   $('.wm-img').watermark({
    path: '{{asset("frontend/image")}}/watermark.png',
    gravity: 's',
    opacity: 0.7,
   
    margin: 0
  });


})
</script>