<div id="<?=$btn_popup?>_title" class="hide" style="line-height: normal;">
	<b>Đăng ký tài khoản </b>
	<span onclick="$('#<?=$btn_popup?>').popover('hide');" class="icon btn-support-close"></span>
</div>

<div id="<?=$btn_popup?>_content" class="hide" style="line-height: normal;">
	<div id="<?=$btn_popup?>_waiting" class="hide" style="width: 300px">
		<?=load_search_waiting($message)?>
	</div>
	<div id="<?=$btn_popup?>_success" class="text-success margin-top-20 margin-bottom-20 hide" style="font-size: 14px;width: 300px">
		<span class="glyphicon glyphicon-ok"></span>
		<?=lang('sign_up_send_success')?>
	</div>
	<div id="<?=$btn_popup?>_form" style="min-width:300px">
		<form id="tryitForm1" class="form-horizontal">
			<div class="margin-top-10">
				<label><?=lang('groupon_email')?>:</label><br>
				<input type="text" id="sign_up_email" class="form-control">
				<div style="padding: 5px 0;" class="hide bpv-color-warning er_sign_up_email">
					Bạn cần nhập đúng thông tin <b>[<?=lang('groupon_email')?>]</b>
				</div>
			</div>
			<div class="margin-top-10" style="white-space:nowrap;">
				<label><?=lang('groupon_phone_number')?></label><br> 
				<input id="sign_up_phone" type="text" class="form-control">
				<div style="padding: 5px 0;" class="hide bpv-color-warning er_sign_up_phone">
					Bạn cần nhập đúng thông tin <b>[<?=lang('groupon_phone_number')?>]</b>
				</div>
			</div>
			<div class="margin-top-10 clearfix">
				<button onclick="send_sign_up_request(this)" data-loading-text="<?=lang('bpv_pro_code_loading')?>" id="<?=$btn_popup?>_hd" data-id="<?=$btn_popup?>" type="button" class="btn btn-bpv btn-book-now pull-right">
					<?=lang('btn_send_request')?>
				</button>
			</div>
		</form>
	</div>
</div>
<style>
	.bv-form .help-block {
		margin-bottom: 0;
	}
	.nav-tabs li.bv-tab-success > a {
		color: #3c763d;
	}
	.nav-tabs li.bv-tab-error > a {
		color: #a94442;
	}
	.bar{
		height: 19px;
		background-color: #5eb95e;
		background-image: linear-gradient(to bottom, #62c462, #57a957);
		background-repeat: repeat-x;
	}
</style>
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
