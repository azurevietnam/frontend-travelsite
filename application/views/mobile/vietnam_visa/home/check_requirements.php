<form id="frmApplyVisa" method="post" action="<?=get_page_url(VN_VISA_APPLY_PAGE)?>">
<div class="visa-requirement-box clearfix">
    <div class="col-xs-12 form-group">
        <label for="ck_nationality"><?=lang('label_select_nationality')?></label>
        <select class="form-control" name="nationality" id="ck_nationality">
			<option value=""><?=lang('please_select_nationality')?></option>
			<?php foreach ($countries as $country) :?>
			<?php
				$url_ct_name = strtolower(trim($country['url_title']));  
				$url_ct_name = str_replace(' ', '-', $url_ct_name);
				$url_ct_name .= '.html';
			?>
			<option value="<?=$url_ct_name?>"><?php echo $country['name']?></option>
			<?php endforeach;?>
		</select>
    </div>
    <div class="col-xs-12">
        <button type="button" class="btn btn-default btn-blue btn-block" onclick="check_requirements()">
        <?=lang('check_requirements')?>
        </button>
    </div>
</div>
</form>

<div class="container margin-top-20 visa-panel">
    <h2 class="text-highlight margin-top-0"><?=lang('vietnam_visa_h1')?></h2>
    <p><?=lang('vietnam_visa_summary')?></p>
    <div class="panel panel-primary">
        <div class="panel-heading"><?=lang('visa_on_arrival')?></div>
        <div class="panel-body" onclick="go_url('<?=site_url('/vietnam-visa/visa-on-arrival.html')?>')">
        <?=lang('visa_on_arrival_description')?><i class="icon icon-chevron-right"></i>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading"><?=lang('vietnam_visa_fee')?></div>
        <div class="panel-body" onclick="go_url('<?=site_url('/vietnam-visa/visa-fees.html')?>')">
        <?=lang('vietnam_visa_fee_description')?><i class="icon icon-chevron-right"></i>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading"><?=lang('how_to_apply')?></div>
        <div class="panel-body" onclick="go_url('<?=site_url('/vietnam-visa/how-to-apply.html')?>')">
        <?=lang('how_to_apply_description')?><i class="icon icon-chevron-right"></i>
        </div>
    </div>
</div>