<div class="panel panel-default bpt-panel">
   <!-- Default panel contents -->
   <div class="panel-heading">
   	    <h2 class="highlight"><b><?=lang('field_about_bestprice_vn')?></b></h2>
   </div>
   
    <!-- List group -->
  	<div class="list-group">
        <a href="<?=get_page_url(ABOUT_US_PAGE)?>" class="list-group-item <?php if($page == ABOUT_US_PAGE) echo 'active';?>">
            <?=lang('label_company_overview')?>
            <span class="icon icon-arrow-right-blue"></span>
        </a>
        <a href="<?=get_page_url(REGISTRATION_PAGE)?>" class="list-group-item <?php if($page == REGISTRATION_PAGE) echo 'active';?>">
            <?=lang('field_company_registration')?>
            <span class="icon icon-arrow-right-blue"></span>
        </a>
        <a href="<?=get_page_url(POLICY_PAGE)?>" class="list-group-item <?php if($page == POLICY_PAGE) echo 'active';?>">
            <?=lang('tpc_terms_conditions')?>
            <span class="icon icon-arrow-right-blue"></span>
        </a>
        <a href="<?=get_page_url(PRIVACY_PAGE)?>" class="list-group-item <?php if($page == PRIVACY_PAGE) echo 'active';?>">
            <?=lang('tpv_privacy_statement')?>
            <span class="icon icon-arrow-right-blue"></span>
        </a>
        <a href="<?=get_page_url(OUR_TEAM_PAGE)?>" class="list-group-item <?php if($page == OUR_TEAM_PAGE) echo 'active';?>">
            <?=lang('meet_our_team')?>
            <span class="icon icon-arrow-right-blue"></span>
        </a>
        <a href="<?=get_page_url(CONTACT_US_PAGE)?>" class="list-group-item <?php if($page == CONTACT_US_PAGE) echo 'active';?>">
            <?=lang('ctu_contact_us')?>
            <span class="icon icon-arrow-right-blue"></span>
        </a>
	</div>

</div>
