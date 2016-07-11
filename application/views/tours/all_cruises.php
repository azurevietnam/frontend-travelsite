<?php 
if ($this->session->userdata('MENU') == MNU_HALONG_CRUISES)
{
    $link_str = 'halongcruises';
    $day_cruise_url = "/halongbaydaycruises/";
}
elseif ($this->session->userdata('MENU') == MNU_MEKONG_CRUISES)
{
    $link_str = 'mekongcruises';
    $day_cruise_url = "/mekongriverdaycruises/";
}
?>
<div>
	<?php if(count($all_cruises['luxury_cruises']) > 0):?>
		<h3 class="highlight">
		<a class="highlight" href="/luxury<?=$link_str?>/">
    		<?=$cruise_destination == HALONG_CRUISE_DESTINATION ? lang('luxuryhalongcruises') : lang('luxurymekongcruises')?>
    		</a>
	</h3>

	<ul>
			<?php foreach ($all_cruises['luxury_cruises'] as $cruise) :?>			
				<li><a
			href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>"><?=$cruise['name']?></a>
					<?php if($cruise['is_new'] == 1):?>
						<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
					<?php endif;?>
				</li>
			<?php endforeach ;?>
		</ul>
	<div class="clearfix"></div>
	<?php endif;?>
	
	<?php if(count($all_cruises['deluxe_cruises']) > 0):?>
		<h3 class="highlight">
		<a class="highlight" href="/deluxe<?=$link_str?>/">
    		<?=$cruise_destination == HALONG_CRUISE_DESTINATION ? lang('deluxehalongcruises') : lang('deluxemekongcruises')?>
    		</a>
	</h3>

	<ul>
			<?php foreach ($all_cruises['deluxe_cruises'] as $cruise) :?>			
				<li><a
			href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>"><?=$cruise['name']?></a>
					<?php if($cruise['is_new'] == 1):?>
						<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
					<?php endif;?>
				</li>
			<?php endforeach ;?>
		</ul>

	<div class="clearfix"></div>
	<?php endif;?>
	
	<?php if(count($all_cruises['cheap_cruises']) > 0):?>
		<h3 class="highlight">
		<a class="highlight" href="/cheap<?=$link_str?>/">
    		<?=$cruise_destination == HALONG_CRUISE_DESTINATION ? lang('cheaphalongcruises') : lang('cheapmekongcruises')?>
    		</a>
	</h3>

	<ul>
			<?php foreach ($all_cruises['cheap_cruises'] as $cruise) :?>			
				<li><a
			href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>"><?=$cruise['name']?></a>
					<?php if($cruise['is_new'] == 1):?>
						<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
					<?php endif;?>
				</li>
			<?php endforeach ;?>
		</ul>

	<div class="clearfix"></div>
	<?php endif;?>
	
	<?php if(count($all_cruises['charter_cruises']) > 0):?>
	<h3 class="highlight">
		<a class="highlight" href="/private<?=$link_str?>/">
    	<?=$cruise_destination == HALONG_CRUISE_DESTINATION ? lang('privatehalongcruises') : lang('privatemekongcruises')?>
    	</a>
	</h3>

	<ul>
		<?php foreach ($all_cruises['charter_cruises'] as $cruise) :?>			
			<li><a
			href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>"><?=$cruise['name']?></a>
				<?php if($cruise['is_new'] == 1):?>
					<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
				<?php endif;?>
			</li>
		<?php endforeach ;?>
	</ul>
	<div class="clearfix"></div>
	<?php endif;?>
	
	<?php if(count($all_cruises['day_cruises']) > 0):?>
	<h3 class="highlight">
		<a class="highlight" href="<?=$day_cruise_url?>">
    	<?=$cruise_destination == HALONG_CRUISE_DESTINATION ? lang('halongbaydaycruises') : lang('mekongriverdaycruises')?>
    	</a>
	</h3>

	<ul>
		<?php foreach ($all_cruises['day_cruises'] as $cruise) :?>			
			<li><a
			href="<?=url_builder(CRUISE_DETAIL, $cruise['url_title'], true)?>"><?=$cruise['name']?></a>
				<?php if($cruise['is_new'] == 1):?>
					<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
				<?php endif;?>
			</li>
		<?php endforeach ;?>
	</ul>
	<?php endif;?>
</div>