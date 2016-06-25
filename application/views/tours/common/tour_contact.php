<div class="container-fluid no-padding tour-contact margin-top-20 margin-bottom-20">
	<?php if(isset($option_contact['mode']) && $option_contact['mode'] == FULL_TOUR_CONTACT):?>
		<?php 
			$col_left	= "col-xs-4 col-xs-offset-2";
			$col_right 	= "col-xs-4";
		?>
	<?php elseif(isset($option_contact['mode']) && $option_contact['mode'] ==RIGHT_TOUR_CONTACT):?>
		<?php 
			$col_left	= "col-xs-6";
			$col_right	= "col-xs-6";
		?>
	<?php else:?>
		<?php 
			$col_left	= "col-xs-6";
			$col_right	= "col-xs-6";
		?>
	
	<?php endif;?>

    <div class="<?=$col_left;?>">
        <h3 class="bpv-color-title"><b><?=lang('tour_contact_us')?></b></h3>
        <p class="desc"><?=lang('tour_contact_us_desc')?></p>
        <img height="300" src="<?=get_static_resources('/media/tour/tour-contact.20102014.png')?>">
    </div>
    <div class="margin-top-20 <?=$col_right;?>">
    	<form role="form" method="post" name="tour_contact" id="form_tour_contact">
    		<?php if(isset($option_contact['tour_name'])):?>
    		<div class="margin-top-10">
	            <span class="glyphicon glyphicon-ok bpv-color-marketing"></span> <label><?=$option_contact['tour_name'];?></label><br>
	            <input type="hidden" class="form-control" id="t_tour_name" name="t_tour_name" value="<?=$option_contact['tour_name'];?>">
	        </div>
    		<?php endif;?>
	        <!-- 
	        <div class="row margin-top-10">
	        	<div class="col-xs-3">
					<label for="adults"><?=lang('tc_adults')?></label>
				    <select class="form-control input-sm" id="adults" name="t_adults">
					  <?php for($i = 1; $i <= CRUISE_TOUR_MAX_ADULTS; $i++):?>
					  	<option value="<?=$i?>" <?=set_select('adults', $i)?>><?=$i?></option>
					  <?php endfor;?>
					</select>
				</div>
				<div class="col-xs-3">
					<label for="children"><?=lang('tc_children')?></label>
				    <select class="form-control input-sm" id="children" name="t_children">
					  <?php for($i = 0; $i <= CRUISE_TOUR_MAX_CHILDREN; $i++):?>
					  	<option value="<?=$i?>" <?=set_select('children', $i)?>><?=$i?></option>
					  <?php endfor;?>
					</select>
				</div>
				<div class="col-xs-3">
					<label for="children"><?=lang('tc_infants')?></label>
				    <select class="form-control input-sm" id="infants" name="t_infants">
					  <?php for($i = 0; $i <= CRUISE_TOUR_MAX_INFANTS; $i++):?>
					  	<option value="<?=$i?>" <?=set_select('infants', $i)?>><?=$i?></option>
					  <?php endfor;?>
					</select>
				</div>
	        </div>
	        
	        <div class="row margin-top-10">
	        	<div class="col-xs-9">
	        		 <label><?=lang('tour_contact_us_departing_from')?></label>
	        		  <span class="icon-after">
	    				<?php 
	    					if(isset($tour_search_criteria)){
	    						
	    						$startdate = $tour_search_criteria['is_default'] || $tour_search_criteria['is_default_date'] || empty($tour_search_criteria['startdate']) || !check_bpv_date($tour_search_criteria['startdate']) ? '' : $tour_search_criteria['startdate'];
	    					}elseif(isset($search_criteria)){
	    						
	    						$startdate = $search_criteria['is_default'] || $search_criteria['is_default_date'] || empty($search_criteria['startdate']) || !check_bpv_date($search_criteria['startdate']) ? '' : $search_criteria['startdate'];
	    					}
	    				?>
	    				<input type="text" class="form-control" id="tour_start_date" name="t_start_date" 
			    		 	placeholder="<?=lang('placeholder_date')?>" value="<?=$startdate?>">
		    			<span class="icon icon-calendar" id="btn_startdate_contact"></span>
		    		</span>
	        	</div>
	        </div>
	        -->
	      	<div class="margin-top-10">
	            <label style="white-space: nowrap;"><?=lang('tour_contact_us_phone')?> <?=mark_required()?></label><br>
	            <input type="text" class="form-control" id="tour_request_phone" name="t_phone" value="<?=set_value('t_phone')?>">
	            <div style="padding: 5px 0;" class="hide bpv-color-warning er_tour_request_phone">
					<?=lang('tc_input_required')?> <b>[<?=lang('groupon_phone_number')?>]</b>
				</div>
				<?php echo form_error('t_phone');?>
	        </div>
	        
	        <div class="margin-top-10">
	            <label><?=lang('tour_contact_us_email')?> <?=mark_required()?></label><br>
	            <input type="text" class="form-control" id="tour_request_email" name="t_email" value="<?=set_value('t_email')?>">
	            <div style="padding: 5px 0;" class="hide bpv-color-warning er_tour_request_email">
					<?=lang('tc_input_required')?> <b>[<?=lang('groupon_email')?>]</b>
				</div>
				<?php echo form_error('t_email');?>
	        </div>
	        
	        <div class="margin-top-10">
	        	<label style="white-space: nowrap;"><?=lang('tour_contact_us_content')?></label><br>
	        	<textarea rows="4" class="form-control" id="tour_request_content" name="t_request"><?=set_value('t_request')?></textarea>
	        </div>
	        <div class="margin-top-10 margin-bottom-5 clearfix">
				<button name="action" value="<?=ACTION_SUBMIT_REQUEST?>" id="tour_contact" class="btn btn-bpv btn-book-now pull-left" 
				    type="submit" onclick="return send_tour_contact_request(this)">
					<?=lang('btn_send_request')?>
					<span class="icon icon-arrow-db"></span>
				</button>
			</div>
		</form>
    </div>
</div>
<?php if(!empty($action) && $action == ACTION_SUBMIT_REQUEST):?>
<script>
$("#btn-tour-support").hide();
$("#tour_contact").show();
$("html, body").animate({ scrollTop: $(".tour-contact").offset().top}, "fast");
</script>
<?php endif;?>