<div class="container">
    <div class="bpv-box margin-top-20">
        <h3 class="box-heading no-margin">
            <?=lang('field_about_bestprice_vn')?>
        </h3>
        <div class="list-group bpv-list-group">
            <a class="list-group-item <?php if($page == ABOUT_US_PAGE) echo 'active';?>" href="<?=get_page_url(ABOUT_US_PAGE)?>">
                <span class="glyphicon glyphicon-chevron-right" style="font-size: 10px; top: 0"></span>
                <?=lang('label_company_overview')?>
            </a>
            <a class="list-group-item <?php if($page == REGISTRATION_PAGE) echo 'active';?>" href="<?=get_page_url(REGISTRATION_PAGE)?>">
                <span class="glyphicon glyphicon-chevron-right" style="font-size: 10px; top: 0"></span>
                <?=lang('field_company_registration')?>
            </a>
            <a class="list-group-item <?php if($page == POLICY_PAGE) echo 'active';?>" href="<?=get_page_url(POLICY_PAGE)?>">
                <span class="glyphicon glyphicon-chevron-right" style="font-size: 10px; top: 0"></span>
                <?=lang('tpc_terms_conditions')?>
            </a>
            <a class="list-group-item <?php if($page == OUR_TEAM_PAGE) echo 'active';?>" href="<?=get_page_url(OUR_TEAM_PAGE)?>">
                <span class="glyphicon glyphicon-chevron-right" style="font-size: 10px; top: 0"></span>
                <?=lang('meet_our_team')?>
            </a>
            <a class="list-group-item <?php if($page == PRIVACY_PAGE) echo 'active';?>" href="<?=get_page_url(PRIVACY_PAGE)?>">
                <span class="glyphicon glyphicon-chevron-right" style="font-size: 10px; top: 0"></span>
                <?=lang('tpv_privacy_statement')?>
            </a>
            <a class="list-group-item <?php if($page == CONTACT_US_PAGE) echo 'active';?>" href="<?=get_page_url(CONTACT_US_PAGE)?>">
                <span class="glyphicon glyphicon-chevron-right" style="font-size: 10px; top: 0"></span>
                <?=lang('ctu_contact_us')?>
            </a>

        </div>
    </div>
</div>
