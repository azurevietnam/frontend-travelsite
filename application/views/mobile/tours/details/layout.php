<div class="container">
    <?=$search_form?>
</div>

<?=$photos?>

<?=$basic_info?>

<?=insert_data_link($itinerary)?>

<?=$price_table?>

<?=$important_info?>

<?php if(!empty($tour['review_number'])):?>
<div class="bpv-collapse margin-top-2">
	<h5 class="heading no-margin" data-target="#tab_reviews">
		<i class="icon icon-star-white"></i>
		<?=lang('tour_reviews')?>
		<i class="bpv-toggle-icon icon icon-arrow-right-white pull-right"></i>
	</h5>
	
	<div id="tab_reviews" class="content" data-url="/reviews/?tour_id=<?=$tour['id']?>&mobile=on">
	</div>
</div>
<?php endif;?>

<div class="bpv-collapse margin-top-2">
    <h5 class="heading no-margin" data-target="#book_tour_form">
		<i class="icon icon-star-white"></i>
		<?=lang('tab_booking')?>
		<i class="bpv-toggle-icon icon icon-arrow-right-white pull-right<?=(isset($action) && $action == ACTION_CHECK_RATE) ? ' icon-arrow-right-white-up' : ''?>"></i>
	</h5>
	<div id="book_tour_form" class="content" <?php if(isset($action) && $action == ACTION_CHECK_RATE) echo 'style="display:block"';?>>
	   
        <?=$check_rate_form?>
        
    	<div class="bpv-rate-loading">
        	<img alt="" src="<?=get_static_resources('media/icon/loading.gif')?>">
        	<h2><?=lang('rate_loading')?></h2>
        </div>
        
        <div id="rate_content">
        	<?=$accommodations?>
        </div>
	</div>
</div>
<?=$similar_tours?>
<div class="container">
	
	<?=$tour_contact?>
</div>
<script>
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
    
    function remake_css() {
    	$( ".heading" ).each(function( index ) {
    		if(index > 0) {
    			$(this).addClass('heading-'+index);
    		}
    	});
    }

    function open_book_tab()
    {
        var book_icon = $('#book_tour_form').prev().find( ".icon" );
        if(! $(book_icon).hasClass( "icon-arrow-right-white-up" ))
        {
        	$( book_icon ).addClass('icon-arrow-right-white-up');
            $('#book_tour_form').css('display', 'block');
        }
    	go_check_rate_position();
    }

    function readmore(id){
    	$('#'+id+'_short').hide();
    	$('#'+id+'_full').show();
    }

    function readless(id){
    	$('#'+id+'_short').show();
    	$('#'+id+'_full').hide();
    }
    
    $( document ).ready(function() {

    	$('.heading').bpvToggle();
        
        init_review_tab('#tab_reviews', true);
        
    	remake_css();

    	<?php if(isset($action) && $action == ACTION_CHECK_RATE):?>
        go_check_rate_position();
        check_accommodation_rates();
        <?php endif;?>

        // set book button event
    	$('.btn-book-tour').click(function(){
    		open_book_tab();
    	});
    	
    	$('#btn_book_t').click(function(){
    		open_book_tab();
    	});
    });
</script>