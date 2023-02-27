<div class="content" style="display: block;">
  <div class="row">
    <div class="col-sm-12">
      <div class="categories ">
        <div class="row">
          <div class="col-sm-12 hover-menu">
            <div class="menu">
              <ul>
                @foreach($category->get_subcategory as $subcategory)
                <li>
                  <a href="{{ route('home.category', [$category->slug, $subcategory->slug]) }}"  class="main-menu"> {{$subcategory->name}}
                    @if(count($subcategory->get_subcategory)>0)
                    <b class="fa fa-angle-right"></b>
                    @endif
                  </a>
                  @if(count($subcategory->get_subcategory)>0)
                  <ul>
                    @foreach($subcategory->get_subcategory as $childcategory)
                    <li><a href="{{ route('home.category',[ $category->slug, $subcategory->slug, $childcategory->slug]) }}" > {{$childcategory->name}}</a></li>
                    @endforeach
                  </ul>
                  @endif
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


  function getCategoryMenu(id, category){
      $('#'+category+id).html("<div style='height:135px' class='loadingData-sm'></div>");
      var url = '{{route("getSubChildMenu", ":id")}}';
      url = url.replace(":id", id);
      $.ajax({
          method:'get',
          url:url,
          success:function(data){
           
              if(data){
                  $('#'+category+id).html(data);
              }else{
                 document.getElementById(category+id).style.display = "none";
              }
          }
      });
  } 