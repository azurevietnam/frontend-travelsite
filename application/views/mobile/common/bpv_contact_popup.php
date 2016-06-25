<div id="<?=$btn_popup?>_title" class="hide" style="line-height: normal;">
	<b><?=$popup_title?></b>
	<span onclick="$('#<?=$btn_popup?>').popover('hide');" class="icon btn-support-close"></span>
</div>

<div id="<?=$btn_popup?>_content" class="hide" style="line-height: normal;">
	<div id="<?=$btn_popup?>_waiting" class="hide" style="width: 300px">
		<?=load_search_waiting($message)?>
	</div>
	<div id="<?=$btn_popup?>_success" class="text-success margin-top-20 margin-bottom-20 hide" style="font-size: 14px;width: 300px">
		<span class="glyphicon glyphicon-ok"></span>
		<?=lang('groupon_send_success')?>
	</div>
	<div id="<?=$btn_popup?>_form" style="min-width:300px">
		<?php if($popup_type == 'groupon'):?>
		<h5 class="bpv-color-hot-deal" style="margin-top: 0"><?=lang('groupon')?></h5>
		<p><?=lang('groupon_desc')?></p>
		<ul type="none" style="padding-left: 10px; font-weight: bold;">
			<li>- <?=lang('groupon_fea_1')?></li>
			<li>- <?=lang('groupon_fea_2')?></li>
			<li>- <?=lang('groupon_fea_3')?></li>
		</ul>
		<?php endif;?>
		
		<input id="popup_type" type="hidden" value="<?=$popup_type?>">
		
		<?php if(!empty($custom_text)):?>
			<p class="text-info">*<?=$custom_text?></p>
		<?php endif;?>
	
		<div class="margin-top-10">
			<?php if($popup_type == 'groupon'):?>
			<label><?=lang('groupon_request')?>:</label><br>
			<textarea id="groupon_request"
				class="form-control" style="font-size: 12px" rows="5"></textarea>
			<?php else:?>
			<label><?=lang('contact_request')?>:</label><br>
			<textarea id="groupon_request"
				class="form-control" style="font-size: 12px" rows="5"></textarea>
			<?php endif;?>
			<div style="padding: 5px 0;" class="hide bpv-color-warning er_groupon_request">
			Bạn cần nhập thông tin <b>[<?=$popup_type == 'groupon' ? lang('groupon_request') : lang('contact_request')?>]</b>
			</div>
		</div>
		<div class="margin-top-10">
			<label><?=lang('groupon_email')?>:</label><br>
			<input type="text" id="groupon_email" class="form-control">
			<div style="padding: 5px 0;" class="hide bpv-color-warning er_groupon_email">
			Bạn cần nhập đúng thông tin <b>[<?=lang('groupon_email')?>]</b>
			</div>
		</div>
		<div class="margin-top-10">
			<label><?=lang('groupon_phone_number')?></label><br> 
			<input id="groupon_phone_number" type="text" class="form-control">
			<div style="padding: 5px 0;" class="hide bpv-color-warning er_groupon_phone_number">
			Bạn cần nhập đúng thông tin <b>[<?=lang('groupon_phone_number')?>]</b>
			</div>
		</div>
		<div class="margin-top-10 clearfix">
			<button onclick="send_contact_request(this)" data-loading-text="<?=lang('bpv_pro_code_loading')?>" id="<?=$btn_popup?>_hd" data-id="<?=$btn_popup?>" type="button" class="btn btn-bpv btn-book-now pull-right">
			<?=lang('btn_send_request')?>
			</button>
		</div>
	</div>
</div>

<script>
$('#<?=$btn_popup?>').popover({
	html: true,
	trigger: 'click',
	template: '<div class="popover bpv_popup"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"><p></p></div></div></div>',
	title: $('#<?=$btn_popup?>_title').html(), 
	content: $('#<?=$btn_popup?>_content').html(),
	placement: 'bottom'
}).on('shown.bs.popover', function(e){
	$('#groupon_request').focus();
});
</script>
