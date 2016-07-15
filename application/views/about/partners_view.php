<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="contentLeft">
	<h3 class="highlight"><?=lang('title_about_our_partner')?><span class="arrow-down"></span></h3>
	<ul>
		<?php $title = ''?>
		<?php foreach ($partner_types as $type => $value):?>
			<?php if(empty($value)) continue;?>
			<?php if($partner_type == $type):?>
				<?php $title = translate_text($value);?>
				<li class="selected"><?=translate_text($value)?><span class="icon icon-s-arrow-left"></span></li>
			<?php else:?>
				<?php 
					$href = '';
					if(!empty($partner_href[$type])) {
						$href = $partner_href[$type].'/';
					}
				?>
				<li><a href="<?=site_url().PARTNERS.$href?>"><?=translate_text($value)?></a><span class="icon icon-s-arrow-left"></span></li>
			<?php endif;?>
		<?php endforeach;?>
		<li class="no-border"><a rel="nofollow" href="/aboutus/contact/request/"><?=lang('link_become_our_partner')?></a><span class="icon icon-s-arrow-left"></span></li>
	</ul>
</div>
<div id="contentMain">
	<div id="partner_list">
		<div class="header"><h3 class="highlight" style="padding: 0"><?=$title?></h3></div>
		<div class="content">
		<?php foreach ($partners as $key => $partner):?>
		<div class="items" style="padding: 5px 0; <?php if(count($partners)-1 != $key){echo 'border-bottom: 1px dotted #CECECE;';}?>">
			
			<?php 
				$website = $partner['website'];
				
				$pos = strpos($website, 'http://');
			
				if ($pos === false){
					
					$website = 'http://'.$website;
					
				} else {
					
				}
			?>
			<ul style="list-style: none;">
				<li>
					<div class="col_1" style="width: 310px; <?php if(!empty($partner['logo'])) echo('padding: 0');?>">
						<?php if(!empty($partner['logo'])):?>
						<div style="float: left;margin-right: 10px">
							<img src="<?=$this->config->item('partner_logo_path') . $partner['logo']?>" width="120" height="30"/>
						</div>
						<?php endif;?>
						<div style="float: left; <?php if(!empty($partner['logo'])) echo('margin-top: 7px');?>">
						<a rel="nofollow" href="<?=$website?>" target="_blank"><?=$partner['short_name']?></a>
						</div>
					</div>
					<span class="col_2" style="width: 190px; <?php if(!empty($partner['logo'])) echo('margin-top: 3px');?>"><?php if(!empty($partner['phone'])):?><?=lang('invoice_tel')?>: <?=$partner['phone']?><?php endif;?></span>
					<span class="col_2" style="width: 190px; <?php if(!empty($partner['logo'])) echo('margin-top: 3px');?>"><?php if(!empty($partner['email'])):?><?=$partner['email']?><?php endif;?></span>
				</li>					
			</ul>
		</div>
		<?php endforeach;?>
		</div>
	</div>
</div>

<script>
	function openLink(link){
		if (link.indexOf('http://') == -1){
			link = 'http://' + link;
		}
		window.open(link, '');
	}
</script>