<div id="hotline_ajax"></div>
<!--/**
 * Load hotline support by ajax
 *
 *
 * @author TinVM
 * @since  Apr 06, 2015
 */

-->
<script>
    $.ajax({
    url: "ajax/hotline_ajax/load_hotline_support/",
    type: "POST",
    success:function(value){
        $( "#hotline_ajax" ).html( value );
    }
    });
</script>