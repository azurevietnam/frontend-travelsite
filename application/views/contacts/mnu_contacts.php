<div class="bpv-filter-box">
    <h3 class="bpv-color-title">
		<span class="icon icon-circle-info"></span><?=lang('about_us_top')?>
    </h3>
	<div class="list-group">
        <ul>
            <li <?php if($active_index == 2) echo 'class="active"'?>>
                <a href="<?=get_url(ABOUT_US_PAGE)?>" class="list-group-item"><?=lang('mnu_about_us')?><span class="icon icon-arrow-right-gray"></span></a>
            </li>
            <li <?php if($active_index == 7) echo 'class="active"'?>>
                <a href="<?=get_url(ACCOMPLISHMENT_PAGE)?>" class="list-group-item"><?=lang('mnu_accomplishment')?><span class="icon icon-arrow-right-gray"></span></a>
            </li>
            <li <?php if($active_index == 8) echo 'class="active"'?>>
                <a href="<?=get_url(TESTIMONIAL_PAGE)?>" class="list-group-item"><?=lang('mnu_testimonial')?><span class="icon icon-arrow-right-gray"></span></a>
            </li>
            <li <?php if($active_index == 9) echo 'class="active"'?>>
                <a href="<?=site_url(BESTPRICE_WITH_PRESS_PAGE)?>" class="list-group-item"><?=lang('mnu_bestprice_with_press')?><span class="icon icon-arrow-right-gray"></span></a>
            </li>
            <li <?php if($active_index == 3) echo 'class="active"'?>>
                <a href="<?=get_url(TERM_CONDITION_PAGE)?>" class="list-group-item"><?=lang('mnu_term_cond')?><span class="icon icon-arrow-right-gray"></span></a>
            </li>
            <li <?php if($active_index == 5) echo 'class="active"'?>>
                <a href="<?=get_url(FAQS_PAGE)?>" class="list-group-item"><?=lang('mnu_faq')?><span class="icon icon-arrow-right-gray"></span></a>
            </li>
            <li <?php if($active_index == 6) echo 'class="active"'?>>
                <a href="<?=get_url(PAYMENT_METHODS_PAGE)?>" class="list-group-item"><?=lang('mnu_payment')?><span class="icon icon-arrow-right-gray"></span></a>
            </li>
            <li <?php if($active_index == 1) echo 'class="active"'?>>
                <a href="<?=get_url(CONTACT_US_PAGE)?>" class="list-group-item"><?=lang('mnu_contact')?><span class="icon icon-arrow-right-gray"></span></a>
            </li>
        </ul>
    </div>
</div>