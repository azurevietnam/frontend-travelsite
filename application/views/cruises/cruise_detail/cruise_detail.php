<div class="container margin-bottom-20">

    <ol class="breadcrumb">
	  <li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
	  <li><a href="<?=site_url(CRUISE_HL_HOME_PAGE)?>"><?=lang('mnu_cruises')?></a></li>
	  <li class="active"><?=$cruise['name']?></li>
	</ol>
	
	<div class="clearfix">
	
		<div class="bpv-col-left">
			<?=$cruise_search_overview?>
			
			<?=$cruise_search_form?>
			
			<div class="margin-top-20 margin-bottom-20">
				<?=load_bpv_call_us(CRUISE)?>
			</div>
			
			<?=$bpv_recent_cruise?>
			
			<?=$similar_cruises_side?>
		</div>
		
		<div class="bpv-col-right">
			
			<?=$cruise_basic_info?>
			
			<?php if( !empty($last_review) ):?>
			<div class="clearfix margin-bottom-10">
				<div class="last-review">
					<span class="content">
						"<?=content_shorten($last_review['review_content'], 160)?>"
					</span>
					<span class="bpv-color-title cus" style="white-space: nowrap;">
						<?=$last_review['customer_name'].' - '.$last_review['city_name']?>
					</span>
				</div>
				<div class="last-review-score">
					<span class="arrow-gr"></span>
					<span class="review-text"><?=get_review_text($cruise['review_score'])?></span>
					<span class="review-score"><?=$cruise['review_score']?></span>
					<span style="clear: both; display: block;">
						<?=lang('rev_out_of').' '?>
						<a href="javascript:void(0)" onclick="open_review('#cruise_tabs')"><?=$cruise['review_number'].' '.lang('rev_txt')?></a>
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
				<?=$cabins?>
			</div>
			
			<?=$cruise_photos?>
		
			<?php if(!empty($cruise['review_number'])):?> 
			<input type="hidden" id="tab" value="<?=isset($tab) ? $tab : ''?>">
			<div class="bpv-tab bpv-details-tab">
				<ul class="nav nav-tabs pull-left" id="cruise_tabs">
					<li class="active">
						<a href="#tab_details" data-toggle="tab"><?=lang('cruise_details')?></a>
					</li>
					<li>
						<a href="#tab_reviews" data-toggle="tab" data-url="/reviews/?cruise_id=<?=$cruise['id']?>"><?=lang('cruise_reviews')?></a>
					</li>
				</ul>
			</div>
			<div class="tab-content" style="float: left; clear: both; margin-top: 10px; width: 100%">
				<div class="tab-pane active" id="tab_details">
					<?=$cruise_tours?>
			 
					<?=$cruise_detail_info?>
				</div>
			
				<div class="tab-pane" id="tab_reviews" style="border-top: 1px solid #ccc">
					
				</div>
			</div>
			<?php else:?>
				<?=$cruise_tours?>
			 
				<?=$cruise_detail_info?>
			<?php endif;?>

		</div>
		
	</div>
	
	<div class="clearfix">
		<?=$similar_cruises?>
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
	
	function check_accommodation_rates(){
		$('.bpv-rate-loading').show();
		$('#rate_content').hide();
	
		$.ajax({
			url: "/cruise_details/check_rates/?" + $('#check_rate_form').serialize(),
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
	
	<?php elseif(!empty($tours)):?>
		<?php if(isset($action) && $action == ACTION_CHECK_RATE):?>
			go_check_rate_position();
		<?php endif;?>
		check_accommodation_rates();
	<?php endif;?>
	
	$('.pop-promotion').on('click', function (e) {
		$('.pop-promotion').not(this).popover('hide');
	});

	init_review_tab('#cruise_tabs');
</script>

