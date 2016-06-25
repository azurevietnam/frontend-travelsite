<div class="container">
	
	<?=$hotel_search_form?>
	 
	<div class="row">
		<?=$hotel_photos?>
	</div>
	
	<div class="row">
		<?=$hotel_basic_info?>
	</div>
	
	<div>
		
		<?=$check_rate_form?>
			
		<div class="bpv-rate-loading" style="display:none">
			<img alt="" src="<?=get_static_resources('media/icon/loading.gif')?>">
			<h2><?=lang('rate_loading')?></h2>
		</div>

	</div>
	
	<div id="rate_content">
		<?=$room_types?>
	</div>
	
	<div class="margin-top-10 margin-bottom-10">
		<?=load_bpv_call_us(HOTEL)?>
	</div>
</div>

<?=$hotel_detail_info?>
	
<?php if(!empty($hotel['review_number'])):?>
<div class="bpv-collapse margin-top-2">
	<h5 class="heading no-margin" data-target="#tab_reviews">
		<i class="icon icon-star-white"></i>
		<?=lang('hotel_reviews')?>
		<i class="bpv-toggle-icon icon icon-arrow-right-white pull-right"></i>
	</h5>
	
	<div id="tab_reviews" class="content" data-url="/reviews/?hotel_id=<?=$hotel['id']?>&mobile=on">
	</div>
</div>
<?php endif;?>

<?=$similar_hotels?>


<script type="text/javascript">

	var gallery_load = new Loader();
	gallery_load.require(
		<?=get_libary_asyn_js('flexsilder')?>, 
	  function() {

			$('.flexslider').flexslider({
				animation: "slide",
				animationLoop: false,
				slideshow: false,
				<?php if(isset($action) && $action == ACTION_CHECK_RATE):?>
				start: function(){go_check_rate_position()},
				<?php endif;?>		    
			    controlNav: false
			  });
			
	  });   
	
	
	// load map.js asynchronously
	function map_callback(){
		
		var map_load = new Loader();
		map_load.require(
				<?=get_libary_asyn_js('map')?>, 
		      function() {
					create_hotel_mobile_map( {
						data_hotel_id : <?=$hotel['id']?>,
						data_des_id : <?=$hotel['destination_id']?>, 	
						data_lat : <?=$hotel['latitude']?>,
						data_lng : <?=$hotel['longitude']?>,
						data_place_name : "<?=$hotel['name']?>", 
						data_star : <?=$hotel['star']?>
					});
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
			//go_check_rate_position();
		<?php endif;?>
		check_room_rates();
	<?php endif;?>

	$('.pop-promotion').on('click', function (e) {
		$('.pop-promotion').not(this).popover('hide');
	});

	init_review_tab('#tab_reviews', true);

	function remake_css() {
		$( ".heading" ).each(function( index ) {
			if(index > 0) {	
				$(this).addClass('heading-'+index);
			}
		});
	}

	$( document ).ready(function() {
		remake_css();

		$('.heading').bpvToggle();
	});
</script>

