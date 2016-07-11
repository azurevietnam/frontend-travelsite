<!-- Indochina Tours -->
<div class="clearfix  margin-top-10 container">
	<h2 class="text-highlight popular-listing-tite">
		<span class="icon icon-tour-special"></span>		
		<?=lang('indochina_tours')?>
	</h2>	<?php 

	?>
		
	<?php foreach ($indochina_destinations as $country):?>
	<div class="indo-col"> 
			<?php if ($country['name'] == 'Vietnam'):?>
				<div class="indo-country"><span class="icon <?=$country['icon_flag']?>"></span> 
					<a class="text-highlight margin-left-5" href="<?=get_page_url(VN_TOUR_PAGE)?>"><?=strtoupper($country['name'].' tours')?></a>
				</div>
			<?php else :?>
				<div class="indo-country"><span class="icon <?=$country['icon_flag']?>"></span> 
					<a class="text-highlight margin-left-5" href="<?=get_page_url(TOURS_BY_DESTINATION_PAGE, $country)?>"><?=strtoupper($country['name'].' tours')?></a>
				</div>
			<?php endif;?>
			
	  		<?php foreach ($country['styles'] as $key => $style):?>
			<div class="indo-tour <?php if($key >= 10):?>tour-hide-<?=$country['name']?><?php endif;?>" <?php if ($key >= 10): ?> style="display: none;" <?php endif;?>>
				
					<span class="text-special arrow-orange margin-right-5">&rsaquo;</span>
					<a href="<?=get_page_url(TOURS_BY_TRAVEL_STYLE_PAGE, $country, $style)?>">
					<?php $style_name = !is_symnonym_words($style['name']) ? lang_arg('tour_travel_style', $style['name']) : $style['name']?>
		            <?=stripos($style_name, $country['name']) !== false ? $style_name : $country['name'].' '.$style_name?>
					</a>		
						

			</div>
			
			<?php endforeach;?>
			<?php if (count($country['styles']) > 10):?>
			<div class="margin-top-15" style="font-size: 14px;" >
				<span class="glyphicon glyphicon-plus-sign text-special" data-hide="glyphicon-plus-sign" data-show="glyphicon-minus-sign" id="more_attration_<?=$country['name']?>"></span>
				<a href="javascript:void(0)" class="attr-show-more-<?=$country['name']?>" data-show="hide" data-target=".tour-hide-<?=$country['name']?>" data-icon="#more_attration_<?=$country['name']?>"><?=lang('label_show_more')?></a>
			</div>
			<script type="text/javascript">
				set_show_hide('.attr-show-more-<?=$country['name']?>');
			</script>
			<?php endif;?>
			
		</div>
		
	<?php endforeach;?>
	
	<div class="indo-col"> 
		<div class="indo-country">
			<span class="icon icon-multi-countries"></span> <a class="text-highlight margin-left-5" href="<?=get_page_url(TOURS_BY_DESTINATION_PAGE, $indochina)?>"> <?=strtoupper(lang('multi_countries_tours'))?></a>
		</div>
		<?php foreach ($indochina['styles'] as $key => $style):?>
			<div class="indo-tour">
				<span class="text-special arrow-orange margin-right-5">&rsaquo;</span>
				<a href="<?=get_page_url(TOURS_BY_TRAVEL_STYLE_PAGE, $indochina, $style)?>">
				<?=!is_symnonym_words($style['name']) ? lang_arg('tour_travel_style', $style['name']) : $style['name']?>
				</a>
			</div>
		<?php endforeach;?>
	</div>
</div>