<div class="photos">

	<div class="header">
		<label class="bpv-color-title"><?=lang('lbl_view')?></label> 
		<a href="javascript:void(0)" name="tab_itinerary" class="btn_tab"><?=lang('tour_itinerary')?></a> 
		<a href="javascript:void(0)" name="tab_booking" class="btn_tab"><?=lang('tour_price')?></a>
	</div>
	
	<?=load_slider($photos)?>
	
</div>

<script>

      $('.btn_tab').click(function (){
          var name = $(this).attr('name');
    	  $('#tour_tabs a[href="#'+name+'"]').tab('show');

    	  $("html, body").animate({ scrollTop: 808}, "fast");
      });
</script>