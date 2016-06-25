<div class="container main-content">

	<div class="row margin-bottom-20">
		<div class="col-xs-6 h-col">
			<?=$bpv_search?>
			
			<div class="margin-top-20">
				<?=$bpv_why_us?>
			</div>
			
			<?=load_random_ad(AD_PAGE_HOME, AD_AREA_2)?>
			
			<div class="bpv-maps" id="vietnam_map" data-lat="16.662344" data-lng="107.103079" data-place-name="Vietnam"></div>
		</div>
		<div class="col-xs-6">
			<?=$bpv_ads?>
			
			<a target="_blank" href="<?=get_url(NEWS_HOME_PAGE, $n_book_together)?>">
				<img class="margin-top-5 margin-bottom-20 img-responsive" src="<?=get_static_resources('/media/banners/bpv-slogan.21102014.jpg')?>">
			</a>
			
			<?php if(!empty($bpv_recent_hotel)):?>
			<?=$bpv_recent_hotel?>
			<?php endif;?>
			
			<?=$bpv_best_hotel?>
		</div>
	</div>
	
	<?=$footer_links?>
</div>

<?=$bpv_register?>

<script type="text/javascript">

	function map_callback(){
		
		var map_load = new Loader();
		map_load.require(
			<?=get_libary_asyn_js('map')?>, 
		    function() {
	
				create_vietnam_top_des_map( {
					lat : 16.662344,
					lng : 107.103079,
					des_name : 'Việt Nam',
					des_id :1,
					zoom :5
				});
			    
		    }); 
		
	}
	
	var map_api_load = new Loader();
	map_api_load.require(
		<?=get_libary_asyn_js('google-map-api', 'map_callback')?>, 
      function() {
		// do nothing
      });   

</script>