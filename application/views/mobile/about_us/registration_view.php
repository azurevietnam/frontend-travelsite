<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="container clearfix">
    <h1 class="highlight"><?=lang('registration_title')?></h1>
    <div id="registration">
        <ul>
            <li><span class="highlight"><?=lang('company_registration_name_address')?></span>
                <p>
                    <?=lang('company_registration_trading')?>: <strong><?=strtoupper(BRANCH_NAME)?>., JSC</strong>
                </p>
                <p>
                    <?=lang('company_registration_name')?>: <strong><?=lang('company_name')?></strong>
                </p>
                <p>
                    <?=lang('company_registration_name_vn')?>: <strong><?=lang('company_name_vn')?></strong>
                </p>
                <p><?=lang('company_registration_licence')?></p>
                <p><?=lang('company_registration_tax')?>: <?=REGISTRATION_TAX_NUMBER?></p>
                <p><?=lang('label_international_tour_operator_license')?> <?=lang('label_international_tour_operator_license_no')?></p>
                <p><?=lang('company_address_office_hn')?></p>
                <p><?=lang('company_address_office_hcmc')?></p></li>
        </ul>
    </div>
    <div class="highslide-gallery">
        <a href="javascript:void(0)"  rel="nofollow" imgurl="<?=get_static_resources('/media/international_tour_operator_licence_1.jpg')?>" class="highslide img-responsive col-xs-6" onclick="return hs.expand(this);">
            <img class="img-responsive" src="<?=get_static_resources('/media/international_tour_operator_licence_1.jpg')?>"></img>
        </a>
        <a href="javascript:void(0)" rel="nofollow" imgurl="<?=get_static_resources('/media/international_tour_operator_licence_2.jpg')?>" class="highslide img-responsive col-xs-6" onclick="return hs.expand(this);">
            <img class="img-responsive" src="<?=get_static_resources('/media/international_tour_operator_licence_2.jpg')?>"></img>
        </a>
    </div>
</div>

<script>
function async_load(){
    var s = document.createElement('script');
    s.type = 'text/javascript';
    s.async = true;
    s.src = '<?=get_static_resources('/js/highslide/highslide-with-gallery-about.min.js', '', true)?>';
    var x = document.getElementsByTagName('script')[0];
    x.parentNode.insertBefore(s, x);
}

async_load();
</script>