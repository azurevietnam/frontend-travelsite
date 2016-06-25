<div class="container main-content">

	<div class="row margin-bottom-20 mod-search">
		
		<div class="col-xs-12">
			<?=$bpv_ads?>
		</div>
		
		<?=$bpv_search?>
	</div>
	
	<div class="row">
		<div class="col-xs-6">	
			<?=$bpv_why_us?>
			
			<a target="_blank" href="<?=get_url(NEWS_HOME_PAGE, $n_book_together)?>">
				<img class="margin-bottom-20 img-responsive" src="<?=get_static_resources('/media/banners/bpv-slogan.21102014.jpg')?>">
			</a>
			
			<a target="_blank" href="/khuyen-mai.html?des_id=16">
				<img class="margin-bottom-20 img-responsive" src="<?=get_static_resources('/media/banners/khuyen-mai-phu-quoc-01-07.jpg')?>">
			</a>
			
			<div class="bpv-newbox top-destinations margin-bottom-20">
				<h3><span class="icon icon-top-des"></span> <?=lang('top_hotel_destinations')?></h3>
				<div class="row content">
					<?php foreach ($top_destinations as $des):?>
					<div class="col-xs-4">
						<span class="arrow-sm"></span>
						<a href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>">
							<?=lang('hotel_txt'). ' ' . $des['name']?>
						</a>
					</div>
					<?php endforeach;?>
				</div>
			</div>
			
			<div class="bpv-maps" id="vietnam_map" data-lat="16.662344" data-lng="107.103079" data-place-name="Vietnam"></div>
		</div>
		<div class="col-xs-6">
			<?=$bpv_recent_hotel?>
			
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