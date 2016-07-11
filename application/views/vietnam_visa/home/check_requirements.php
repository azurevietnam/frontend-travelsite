<form id="frmApplyVisa" method="post" action="<?=get_page_url(VN_VISA_APPLY_PAGE)?>">
<div class="visa-requirement-box">
    <h2 class="text-highlight margin-bottom-5"><?=lang('label_select_nationality')?></h2>
    <div class="sub-header"><?=lang('label_vevo')?></div>
    
    <div class="row margin-top-20">
        <div class="col-xs-5">
            <select name="nationality" id="ck_nationality">
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
        <div class="col-xs-4 padding-left-0">
            <button type="button" onclick="check_requirements()" class="btn btn-green"><?=lang('check_requirements')?></button>
        </div>
    </div>
    
    <div class="clearfix margin-top-10 margin-bottom-20"><?=load_free_visa_popup($is_mobile)?></div>
    
    <div class="<?=!empty($common_ad) ? 'visa-service-box' : 'row'?>">
        <div class="col-xs-4 servicebox <?=!empty($common_ad) ? 'padding-left-0' : ''?>">
            <a href="/vietnam-visa/visa-on-arrival.html" class="box-content">
                <span class="servicetit text-highlight"><span class="icon icon-voa-step-1"></span><?=lang('visa_on_arrival')?></span>
    			<span class="service-content">
    				<?=lang('visa_on_arrival_description')?>
    			</span>
    			<label><?=lang('visa_learn_more')?></label>
    		</a>
        </div>
        <div class="col-xs-4 servicebox">
            <a href="/vietnam-visa/visa-fees.html" class="box-content">
                <span class="servicetit line-2 text-highlight"><span class="icon icon-voa-step-2"></span><?=lang('vietnam_visa_fee')?></span>
    			<span class="service-content">
    				<?=lang('vietnam_visa_fee_description')?>
    			</span>
    			<label><?=lang('visa_learn_more')?></label>
    		</a>
        </div>
        <div class="col-xs-4 servicebox">
            <a href="/vietnam-visa/how-to-apply.html" class="box-content">
                <span class="servicetit line-3 text-highlight"><span class="icon icon-voa-step-3"></span><?=lang('how_to_apply')?></span>
    			<span class="service-content">
    				<?=lang('how_to_apply_description')?>
    			</span>
    			<label><?=lang('visa_learn_more')?></label>
    		</a>
        </div>
    </div>
    
    <?=!empty($common_ad) ? $visa_information : ''?>
</div>
</form>