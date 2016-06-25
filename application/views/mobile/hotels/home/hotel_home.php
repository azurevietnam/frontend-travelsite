<?=$bpv_ads?>
<div class="container">
    <?=$bpv_search?>
    
    <?=load_bpv_call_us(HOTEL)?>
    
	<div class="bpv-box margin-top-10">
	    <h3 class="box-heading no-margin"><?=lang('top_hotel_destinations')?></h3>
		
		<div class="list-group bpv-list-group">
	  
  		<?php foreach ($top_destinations as $des):?>
			<a class="list-group-item" href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>">
			   <i class="icon icon-arrow-right-blue"></i>  <?=lang('hotel_txt'). ' ' . $des['name']?> <span class="badge"><?=$des['number_of_hotels']?></span>
    				</a>
				<?php endforeach;?>

	    </div>
	</div>
</div>
<script>
	$('.bpv-search').show();
</script>


