<div class="clearfix"></div>
<div class="row ">
	<div class="bpv-list">
		<h2 class="bpv-color-title margin-top-20"><?=lang('tour_contact_us')?></h2>
	</div>
</div>
<form role="form" method="post" name="tour_contact" id="form_tour_contact" action="/tour_request/">
    <?php if(isset($option_contact['tour_name'])):?>
	    <div class="margin-top-10">
			<span class="glyphicon glyphicon-ok bpv-color-marketing"></span> <label style="display:inline;"><?=$option_contact['tour_name'];?></label><br>
	        <input type="hidden" class="form-control" id="t_tour_name" name="t_tour_name" value="<?=$option_contact['tour_name'];?>">
		</div>
    <?php endif;?>
    
    <div class="margin-top-10">
        <label><?=lang('tour_contact_us_phone')?> <?=mark_required()?></label><br>
        <input type="text" class="form-control" id="tour_request_phone" name="t_phone">
        <div style="padding: 5px 0;" class="hide bpv-color-warning er_tour_request_phone">
			<?=lang('tc_input_required')?> <b>[<?=lang('groupon_phone_number')?>]</b>
		</div>
    </div>
        
    <div class="margin-top-10">
    	<label><?=lang('tour_contact_us_email')?> <?=mark_required()?></label><br>
        <input type="text" class="form-control" id="tour_request_email" name="t_email">
        <div style="padding: 5px 0;" class="hide bpv-color-warning er_tour_request_email">
			<?=lang('tc_input_required')?> <b>[<?=lang('groupon_email')?>]</b>
		</div>
    </div>
        
    <div class="margin-top-10">
        <label><?=lang('tour_contact_us_content')?></label><br>
    	<textarea rows="4" class="form-control" id="tour_request_content" name="t_request"></textarea>
    </div>
    
    <div class="margin-top-10 clearfix">
		<button onclick="return send_tour_contact_request(this)" id="tour_contact" class="btn btn-bpv btn-book-now pull-left" type="submit">
			<?=lang('btn_send_request')?>
			<span class="icon icon-arrow-db"></span>
		</button>
	</div>
</form>
