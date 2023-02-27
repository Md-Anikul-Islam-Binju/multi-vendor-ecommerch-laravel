<?php  $sections = App\Models\HomepageSection::where('type', 'section')->orderBy('position', 'asc')->get(); ?>

    <div class="bt-switch">
        @foreach($sections as $section)
        <?php $product_id =  explode(',', $section->product_id); ?>
        <h4>Allow {{$section->title}}</h4>
        <div class="m-b-30">
            <input  onchange="highlightAddRemove({{$section->id.', '.$product->id}})" type="checkbox" {{ in_array($product->id, $product_id) ? 'checked' : ''}} data-on-color="warning" data-off-color="danger" data-on-text="Enabled" data-off-text="Disabled"> 
        </div>
        @endforeach
    </div>

    <!-- bt-switch -->
    <script src="{{asset('assets')}}/node_modules/bootstrap-switch/bootstrap-switch.min.js"></script>
    <script type="text/javascript">
    $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
    var radioswitch = function() {
        var bt = function() {
            $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioState")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1)
            })
        };
        return {
            init: function() {
                bt()
            }
        }
    }();
    $(document).ready(function() {
        radioswitch.init()
    });
    </script>