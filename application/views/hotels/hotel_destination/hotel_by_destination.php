<div class="container main-content">
	<ol class="breadcrumb">
	  <li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
	  <li><a href="<?=site_url(HOTEL_HOME_PAGE)?>"><?=lang('mnu_hotels')?></a></li>
	  
	  <?php if(!empty($parents)):?>
	  <?php foreach ($parents as $des):?>
	  	<li><a href="<?=get_url(HOTEL_DESTINATION_PAGE, $des)?>"><?=$des['name']?></a></li>
	  <?php endforeach;?>
	  <?php endif;?>
	  
	  <li class="active"><?=$destination['name']?></li>
	</ol>
	
	<h1 class="bpv-color-title">
	<?= is_root_destination($destination) ? lang('hotel_in_title') . $destination['name'] : lang('hotel_around_title') . $destination['name'];?>
	</h1>
	
	<div class="row">
		<div class="col-xs-6">
			<?=$bpv_search?>
			
			<div class="margin-top-20">
			<?=$bpv_why_us?>
			</div>
			
			<?php if(!empty($bpv_ads_2)):?>
				<div class="margin-bottom-20">
				<?=$bpv_ads_2?>
				</div>
			<?php endif;?>
		
			<?=$place_of_interest?>
			
			<?=$quick_search_links?>
			
			<div class="bpv-wrapper-maps">
				<div class="embedded_map_loading hide"></div>
				<div class="bpv-maps" id="hotel_des_map" data-lat="<?=$destination['latitude']?>" data-lng="<?=$destination['longitude']?>"
				data-place-name="<?=$destination['name']?>" data-des-id="<?=$destination['id']?>">
				</div>
				<div class="view_hotel_destination_map" style="float:right;margin-top: -15px;">
					<button type="button" class="btn btn-primary btn-sm" data-lat="<?=$destination['latitude']?>" data-lng="<?=$destination['longitude']?>"
				data-place-name="<?=$destination['name']?>" data-des-id="<?=$destination['id']?>" onclick="view_hotel_destination_map(this)" >Xem bản đồ lớn </button> 
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<?php if(!empty($bpv_ads_default)):?>
				<?=$bpv_ads_default?>
			<?php elseif(!empty($deal_in_destination)):?>
				<?=$deal_in_destination?>
			<?php else:?>
				
				<?php 
					$img_src = get_static_resources('/media/hotel/khach-san-vietnam-05062014.jpg');
					
					if(!empty($destination['picture'])) { 
						//$img_src = get_static_resources('/images/destinations/'.$destination['picture']);
					    $img_src = get_image_path(DESTINATION, $destination['picture']);
					}
					else if( $destination['type'] != DESTINATION_TYPE_CITY && !empty($city['picture'])) {
						//$img_src = get_static_resources('/images/destinations/'.$city['picture']);
					    $img_src = get_image_path(DESTINATION, $destination['picture']);
					}
				?>
					
				<div class="deal-item-h-des" style="cursor: default;">
					<?php if(!empty($destination['number_of_hotels'])):?>
						<div class="deal-content">
							<div class="hotel-des-info">
								<span class="des-name"><?=$destination['name']?></span>
								<span class="des-numb-hotel"><?=$destination['number_of_hotels']?></span>
								<span class="des-hotel"><?=lang('hotel_txt')?></span>
							</div>
						</div>
					<?php endif;?>
					
					<img class="deal-img" style="margin-top:0" src="<?=$img_src?>">
				</div>
			<?php endif;?>
			
			<div class="margin-top-10">
				<a href="<?=get_url('khuyen-mai/dat-kem-dich-vu-de-nhan-gia-uu-dai-10.html')?>" target="_blank">
					<img class="img-responsive" src="<?=get_static_resources('/media/banners/bpv-slogan-hotel-des.jpg')?>">
				</a>
			</div>
			
			<?php if( !empty($hotels) ):?>
			
				<div class="bpv-unbox margin-top-20">
					<h2 class="bpv-color-title">
						<?php if( is_root_destination($destination) ):?>
						<?=lang('top_ten_hotel'). ' ' . $destination['name']?>
						<?php else:?>
						<?=lang('around_hotel'). ' ' . $destination['name']?>
						<?php endif;?>
					</h2>
					
					<?=$hotel_list_in_des?>
					
					<div class="col-xs-12 view-more">
						<a href="<?=get_url(HOTEL_SEARCH_PAGE, $url_params)?>">
							<span class="glyphicon glyphicon-chevron-right bpv-color-star"></span>
							<?php 
								$number_of_hotels = !empty($destination['number_of_hotels']) ? $destination['number_of_hotels'] : '';
								
								if(is_root_destination($destination)) {
									echo lang_arg('view_more_hote_in_des', $number_of_hotels, $destination['name']);
								} else {
									echo lang_arg('view_more_hote_around_des', $number_of_hotels, $destination['name']);
								}
							?>
						</a>
					</div>
				</div>
			
			<?php endif;?>
		</div>
	</div>

</div>

<?=$hotel_list_by_star?>

<?=$bpv_register?>

<script type="text/javascript">

	function map_callback(){
		
		var map_load = new Loader();
		
		map_load.require(
		<?=get_libary_asyn_js('map')?>,
		function() {

			create_hotel_destination_map( {
				lat : <?=$destination['latitude']?>,
				lng : <?=$destination['longitude']?>,
				des_id : <?=$destination['id']?>
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