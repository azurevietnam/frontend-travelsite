<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php 
	if ($this->session->userdata('MENU') == MNU_HALONG_CRUISES){
		$cruise_port_str = "halongcruises";
	}elseif($this->session->userdata('MENU') == MNU_MEKONG_CRUISES){
		$cruise_port_str = "mekongcruises";
	}
?>

<h2 class="highlight"><?=lang('cruise_by_budget')?></h2>
<div>
	<?php if(count($cruise_by_budget['luxury_cruises']) > 0):?>
	<h3 class="highlight"><a class="highlight" href="/luxury<?=$cruise_port_str?>/"><?=lang('luxury_cruises')?></a></h3>	
	<ul>
		<?php foreach ($cruise_by_budget['luxury_cruises'] as $value) :?>					
			<li>
				<a href="<?=url_builder(CRUISE_DETAIL, $value['url_title'], true)?>"><?=$value['name']?></a>
				<?php 
					$class_tours = $value['star'];
					$star_infor = get_star_infor_tour($class_tours, 0);
				?>
				<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>
			</li>
		<?php endforeach ;?>
	</ul>
	<?php endif;?>
	
	<?php if(count($cruise_by_budget['deluxe_cruises']) > 0):?>
	<h3 class="highlight"><a class="highlight" href="/deluxe<?=$cruise_port_str?>/"><?=lang('deluxe_cruises')?></a></h3>	
	<ul>
		<?php foreach ($cruise_by_budget['deluxe_cruises'] as $value) :?>
																						
			<li>
				<a href="<?=url_builder(CRUISE_DETAIL, $value['url_title'], true)?>"><?=$value['name']?></a>
				<?php 
					$class_tours = $value['star'];
					$star_infor = get_star_infor_tour($class_tours, 0);
				?>
				<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>
			</li>
		
		<?php endforeach ;?>
	</ul>
	<?php endif;?>
	
	<?php if(count($cruise_by_budget['cheap_cruises']) > 0):?>
	<h3 class="highlight"><a class="highlight" href="/cheap<?=$cruise_port_str?>/"><?=lang('cheap_cruises')?></a></h3>	
	<ul>
		<?php foreach ($cruise_by_budget['cheap_cruises'] as $value) :?>																					
			<li>
				<a href="<?=url_builder(CRUISE_DETAIL, $value['url_title'], true)?>"><?=$value['name']?></a>
				<?php 
					$class_tours = $value['star'];
					$star_infor = get_star_infor_tour($class_tours, 0);
				?>
				<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>
			</li>		
		<?php endforeach ;?>
	</ul>
	<?php endif;?>
	
	<?php if(count($cruise_by_budget['charter_cruises']) > 0):?>
	<h3 class="highlight"><?=lang('charter_cruises')?></h3>	
	<ul>
		<?php foreach ($cruise_by_budget['charter_cruises'] as $value) :?>																					
			<li>
				<a href="<?=url_builder(CRUISE_DETAIL, $value['url_title'], true)?>"><?=$value['name']?></a>
				<?php 
					$class_tours = $value['star'];
					$star_infor = get_star_infor_tour($class_tours, 0);
				?>
				<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>
			</li>		
		<?php endforeach ;?>
	</ul>
	<?php endif;?>

</div>