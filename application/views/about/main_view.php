<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="contentLeft">
	<h3 class="highlight"><?=lang('about')?> <?=BRANCH_NAME?>
	<span class="arrow-down"></span>
	</h3>
	<ul>
		<?php if($selected == 1):?>
			<li class="selected"><?=lang('label_company_overview')?><span
			class="icon icon-s-arrow-left"></span></li>
		<?php else:?>
			<li><a href="/aboutus/"><?=lang('label_company_overview')?></a><span
			class="icon icon-s-arrow-left"></span></li>
		<?php endif;?>
		
		<?php if($selected == 2):?>
			<li class="selected"><?=lang('registration_title')?><span
			class="icon icon-s-arrow-left"></span></li>
		<?php else:?>
			<li><a href="/aboutus/registration/"><?=lang('registration_title')?></a><span
			class="icon icon-s-arrow-left"></span></li>
		<?php endif;?>
		
		<?php if($selected == 3):?>
			<li class="selected"><?=lang('tpc_terms_conditions')?><span
			class="icon icon-s-arrow-left"></span></li>
		<?php else:?>
			<li><a rel="nofollow" href="/policy/"><?=lang('tpc_terms_conditions')?></a><span
			class="icon icon-s-arrow-left"></span></li>
		<?php endif;?>
		
		<?php if($selected == 6):?>
			<li class="selected"><?=lang('privacy_title')?><span
			class="icon icon-s-arrow-left"></span></li>
		<?php else:?>
			<li><a rel="nofollow" href="/policy/privacy/"><?=lang('privacy_title')?></a> <span
			class="icon icon-s-arrow-left"></span></li>
		<?php endif;?>
		
		
		<?php if($selected == 4):?>
			<li class="selected"><?=lang('our_team_title')?><span
			class="icon icon-s-arrow-left"></span></li>
		<?php else:?>
			<li><a rel="nofollow" href="/our-team/"><?=lang('our_team_title')?></a><span
			class="icon icon-s-arrow-left"></span></li>
		<?php endif;?>
		
		<?php if($selected == 5):?>
			<li class="selected"><?=lang('contact_title')?><span class="icon icon-s-arrow-left"></span></li>
		<?php else:?>
			<li class="no-border"><a href="/aboutus/contact/"><?=lang('contact_title')?></a><span
			class="icon icon-s-arrow-left"></span></li>
		<?php endif;?>
	</ul>
</div>
<div id="contentMain"><?=$main_content?></div>