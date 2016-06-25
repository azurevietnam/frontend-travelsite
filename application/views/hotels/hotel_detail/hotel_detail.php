<div class="container margin-bottom-20">

    <ol class="breadcrumb">
        <li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
        <li><a href="<?=site_url(HOTEL_HOME_PAGE)?>"><?=lang('mnu_hotels')?></a></li>
        <?php foreach ($parents as $des):?>
        <li><a href="<?=site_url(HOTEL_DESTINATION_PAGE.$des['url_title'].'-'.$des['id'].'.html')?>"><?=$des['name']?></a></li>
        <?php endforeach;?>
        <li class="active"><?=$hotel['name']?></li>
	</ol>
	
	<div class="clearfix">
	
		<div class="bpv-col-left">
			<?=$hotel_search_overview?>
			
			<?=$hotel_search_form?>
			
			<div class="margin-top-20 margin-bottom-20">
				<?=load_bpv_call_us(HOTEL)?>
			</div>
			
			<?=$bpv_recent_hotel?>
			
			<?=$same_class_hotels?>
			
			<?php if(!empty($same_des_hotels)):?>
			<?=$same_des_hotels?>
			<?php endif;?>
		</div>
		
		<div class="bpv-col-right">
			
			<?=$hotel_basic_info?>
			
			<?php if( !empty($last_review) ):?>
			<div class="clearfix margin-bottom-10">
				<div class="last-review">
					<span class="content">
						"<?=content_shorten($last_review['review_content'], 160)?>"
					</span>
					<span class="bpv-color-title cus">
						<?=$last_review['customer_name'].' - '.$last_review['city_name']?>
					</span>
				</div>
				<div class="last-review-score">
					<span class="arrow-gr"></span>
					<span class="review-text"><?=get_review_text($hotel['review_score'])?></span>
					<span class="review-score"><?=$hotel['review_score']?></span>
					<span style="clear: both; display: block;">
						<?=lang('rev_out_of').' '?>
						<a href="javascript:void(0)" onclick="open_review('#hotel_tabs')"><?=$hotel['review_number'].' '.lang('rev_txt')?></a>
					</span>
				</div>
			</div>
			<?php endif;?>
				
			<?=$check_rate_form?>
			
			<div class="bpv-rate-loading" style="display:none">
				<img alt="" src="<?=get_static_resources('media/icon/loading.gif')?>">
				<h2><?=lang('rate_loading')?></h2>
			</div>
			
			<div id="rate_content">
				<?=$room_types?>
			</div>
			
			<div class="margin-top-10 margin-bottom-10 row">
				<div class="col-xs-4 col-xs-offset-8">
					<?=load_bpv_call_us(HOTEL)?>
				</div>
			</div>
			
			<?=$hotel_photos?>
			
			<!-- 
			<div class="hotel-detail-tab">
				<ul class="nav nav-pills">
				  <li class="active"><a href="javascript:void(0)"><?=lang('hotel_detail_info')?></a></li>
				  <li><a href="javascript:void(0)"><?=lang('hotel_review')?></a></li>
				</ul>		
			</div>
			 -->
			
			<?php if(!empty($hotel['review_number'])):?>
			<input type="hidden" id="tab" value="<?=isset($tab) ? $tab : ''?>">
			<div class="bpv-tab bpv-details-tab">
				<ul class="nav nav-tabs pull-left" id="hotel_tabs">
					<li class="active">
						<a href="#tab_details" data-toggle="tab"><?=lang('hotel_details')?></a>
					</li>
					<li>
						<a href="#tab_reviews" data-toggle="tab" data-url="/reviews/?hotel_id=<?=$hotel['id']?>"><?=lang('hotel_reviews')?></a>
					</li>
				</ul>
			</div>
			<div class="tab-content" style="float: left; clear: both; margin-top: 10px; width: 100%">
				<div class="tab-pane active" id="tab_details">
					<?=$hotel_detail_info?>
				</div>
			
				<div class="tab-pane" id="tab_reviews" style="border-top: 1px solid #ccc">
					
				</div>
			</div>
			<?php else:?>
				<?=$hotel_detail_info?>
			<?php endif;?>
			
		</div>
		
	</div>
	
	<div class="clearfix">
		<?=$similar_hotels?>
	</div>
	
</div>
		
<?=$bpv_register?>

<script type="text/javascript">
	
	var gallery_load = new Loader();
	gallery_load.require(
		<?=get_libary_asyn_js('image-gallery')?>, 
	  function() {

			var gallery_setup_load = new Loader();
			gallery_setup_load.require(
				<?=get_libary_asyn_js('image-gallery-setup')?>, 
			  function() {
				// do nothing on callback
			  });  
			  
		
	  });   
	
	
	// load map.js asynchronously
	function map_callback(){
		
		var map_load = new Loader();
		map_load.require(
				<?=get_libary_asyn_js('map')?>, 
		      function() {
					// do nothing on callback
		      });   
		
	}

	// load map api libary
	var map_api_load = new Loader();
	map_api_load.require(
		<?=get_libary_asyn_js('google-map-api', 'map_callback')?>, 
	  function() {
		// do nothing on callback
	  });   		
	
	function check_room_rates(){
		$('.bpv-rate-loading').show();
		$('#rate_content').hide();
	
		$.ajax({
			url: "/hotel_details/check_rates?" + $('#check_rate_form').serialize(),
			type: "GET",
			cache: true,
			data: {
			},
			success:function(value){
				$('.bpv-rate-loading').hide();

				$('#rate_content').html(value);

				$('#rate_content').show();
			},
			error:function(var1, var2, var3){
				
			}
		});	

	}
	

	<?php 
 		$startdate = $check_rate_info['is_default'] ? '' : $check_rate_info['startdate'];
 	?>
	init_hotel_date('#checkin_date', '#stay_night', '#checkout_date', '#checkout_date_display', '<?=$startdate?>');

	<?php if($check_rate_info['is_default']):?>

	<?php else:?>
		<?php if(isset($action) && $action == ACTION_CHECK_RATE):?>
			go_check_rate_position();
		<?php endif;?>
		check_room_rates();
	<?php endif;?>

	$('.pop-promotion').on('click', function (e) {
		$('.pop-promotion').not(this).popover('hide');
	});

	init_review_tab('#hotel_tabs');
</script>

