<div class="container">
    <?=$cruise_search_form?>
</div>

<?=$cruise_basic_info?>

<div class="container">
    <?=$check_rate_form?>	
    
    <div class="bpv-rate-loading">
    	<img alt="" src="<?=get_static_resources('media/icon/loading.gif')?>">
    	<h2><?=lang('rate_loading')?></h2>
    </div> 
</div>

<div id="rate_content">
	<?=$cabins?>
</div>

<?=$cruise_tours?>

<?=$cruise_detail_info?>

<?php if(!empty($cruise['review_number'])):?>
<div class="bpv-collapse margin-top-2">
	<h5 class="heading no-margin" data-target="#tab_reviews">
		<i class="icon icon-star-white"></i>
		<?=lang('cruise_reviews')?>
		<i class="bpv-toggle-icon icon icon-arrow-right-white pull-right"></i>
	</h5>
	
	<div id="tab_reviews" class="content" data-url="/reviews/?cruise_id=<?=$cruise['id']?>&mobile=on">
	</div>
</div>
<?php endif;?>
	
<?=$similar_cruises?>

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

				remake_css();
			},
			error:function(var1, var2, var3){
				
			}
		});	
	
	}

	$('.heading').bpvToggle();
	
	<?php 
		$startdate = $check_rate_info['is_default'] ? '' : $check_rate_info['startdate'];
	?>
	init_hotel_date('#checkin_date', '#stay_night', '#checkout_date', '#checkout_date_display', '<?=$startdate?>');
	
	<?php if($check_rate_info['is_default']):?>
	
	<?php elseif(!empty($tours)):?>
		<?php if(isset($action) && $action == ACTION_CHECK_RATE):?>
			//go_check_rate_position();
		<?php endif;?>
		check_accommodation_rates();
	<?php endif;?>

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
	});
</script>

