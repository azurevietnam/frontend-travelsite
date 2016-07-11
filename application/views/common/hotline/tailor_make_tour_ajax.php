<div id="tailor_make_tour"></div>
<script>
    $.ajax({
        url: "ajax/hotline_ajax/load_tailor_make_tour/",
        type: "POST",
        success:function(value){
            $( "#tailor_make_tour" ).html( value );
        }
    });
</script>