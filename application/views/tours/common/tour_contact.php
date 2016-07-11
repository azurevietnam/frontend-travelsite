<?php if($is_collapsed):?>
<div class="box-support" id="box-support">
    <div class="support-content">
	    <img src="<?=get_static_resources('/media/tour/tour-support.20102014.png')?>" class="live-support">
		<div class="highlight"><?=lang('label_tour_contact_1')?></div>
		<i><?=lang('label_tour_contact_2')?></i>
		<div style="text-align: center; margin-top: 5px">
			<div class="btn_general btn_book_it" onclick="go_url('/aboutus/contact/')"><?=lang('tour_contact_us')?></div>
		</div>
	</div>
</div>
<?php else:?>

<div class="tour-contact" <?=$is_collapsed ? 'style="display:none"' : ''?>>
	<div class="col-left">
		<h2 class="highlight"><?=lang('tour_contact_us')?></h2>
		<p class="desc"><?=lang('tour_contact_us_desc')?></p>
		<img width="300" src="<?=get_static_resources('/media/tour/tour-contact.21102014.png')?>">
	</div>
	<div class="col-right">
		<form role="form" method="post" name="tour_contact"
			id="form_tour_contact" action="/tour_request/">
    		<?php if(isset($option_contact['tour_name'])):?>
    		<div class="margin-top-10">
				<label><?=$option_contact['tour_name'];?></label><br>
				<input type="hidden" class="form-control" id="t_tour_name"
					name="tour_name" value="<?=$option_contact['tour_name'];?>">
			</div>
    		<?php endif;?>
    		<div class="margin-top-10">
				<label><?=lang('tour_contact_us_full_name')?> <?=mark_required()?></label><br>
				<div style="display: inline-block; width: 40px;">
				    <select name="title">
        				<option value="1" <?=set_select('title', '1')?>><?=lang('mr') ?></option>
        				<option value="2" <?=set_select('title', '2')?>><?=lang('ms') ?></option>
        			</select>
				</div>
				<div style="display: inline-block; width: 240px; margin-left: 10px">
				    <input type="text" class="fe_tour_request" id="tour_request_full_name" name="full_name" style="width: 240px">
				</div>
				<div class="er_tour_request hide error er_tour_request_full_name">
			        <?=lang('tour_contact_us_full_name')?> <?=lang('tc_input_required')?>
				</div>
			</div>
			
			<div class="margin-top-10">
				<label><?=lang('tour_contact_us_email')?> <?=mark_required()?></label><br>
				<input type="text" class="fe_tour_request form-control" id="tour_request_email" name="email">
				<div class="er_tour_request hide error er_tour_request_email">
					<?=lang('tour_contact_us_email')?> <?=lang('tc_input_required')?>
				</div>
			</div>
			
	      	<div class="margin-top-10">
				<label><?=lang('tour_contact_us_phone')?> <?=mark_required()?></label><br>
				<input type="text" class="fe_tour_request form-control" id="tour_request_phone" name="phone">
				<div class="er_tour_request hide error er_tour_request_phone">
			        <?=lang('tour_contact_us_phone')?> <?=lang('tc_input_required')?>
				</div>
			</div>
			
			<div class="margin-top-10">
			    <label><?=lang('country')?> <?=mark_required()?></label><br>
    			<select name="country" class="fe_tour_request form-control" id="tour_request_country">
    				<option value=""><?='-- ' . lang('select_country') .' --'?></option>
    				<?php foreach ($countries as $key => $country) :?>
    				<option value="<?=$key?>" <?=set_select('country', $key)?>><?=$country[0]?></option>
    				<?php endforeach;?>
    			</select>
    			<div class="er_tour_request hide error er_tour_request_country">
					<?=lang('country')?> <?=lang('tc_input_required')?>
				</div>
			</div>

			<div class="margin-top-10">
				<label><?=lang('tour_contact_us_content')?> <?=mark_required()?></label><br>
				<textarea rows="4" class="fe_tour_request form-control" id="tour_request_content" name="message"></textarea>
				<div class="er_tour_request hide error er_tour_request_message">
					<?=lang('tour_contact_us_content')?> <?=lang('tc_input_required')?>
				</div>
			</div>
	
			<div class="margin-top-10">
				<input type="submit" onclick="return send_tour_request()"
					class="btn_general select_this_cruise" value="<?=lang('submit')?>">
			</div>
		</form>
	</div>
</div>
<?php endif;?>

<script>
    function send_tour_request(){
 
    	// validate tour_contact_form 
    	var status = true;
    	var email	=	$('#tour_request_email').val();
    	var phone   =   $('#tour_request_phone').val();
    	
    	$('.er_tour_request').addClass('hide');

    	if(! $('#tour_request_full_name').val() ) {
    		$('#tour_request_full_name').focus();
    		$('.er_tour_request_full_name').removeClass('hide');
    		status = false;
    	}

    	if(!IsPhone(phone)) {
    		$('#tour_request_phone').focus();
    		$('.er_tour_request_phone').removeClass('hide');
    		status = false;
    	}

    	if(!IsEmail(email)) {
    		$('#tour_request_email').focus();
    		$('.er_tour_request_email').removeClass('hide');
    		$('.er_tour_request_email').html('<?=lang("email_valid")?>');
    		status = false;
    	}

    	if(! $('#tour_request_content').val() ) {
    		$('#tour_request_content').focus();
    		$('.er_tour_request_message').removeClass('hide');
    		status = false;
    	}

    	if(! $('#tour_request_country').val() ) {
    		$('#tour_request_country').focus();
    		$('.er_tour_request_country').removeClass('hide');
    		status = false;
    	}

    	return status;
    }

    function IsPhone(a) {
    	var filter = /^[0-9-+]+$/;
    	if (filter.test(a)) {
    		return true;
    	}
    	else {
    		return false;
    	}
    }

    function IsEmail(email) {
    	  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    	  return regex.test(email);
    }

    function box_support()
    {
        $('#box-support').hide();
        $('.tour-contact').show();
    }
</script>