<?php if(!empty($destination_styles)):?>
<div class="bpv-box">
    <h3 class="box-heading no-margin"><?=lang_arg('title_vn_tour_by_travel_style', $destination['name'])?></h3>
	<div class="list-group bpv-list-group">
        <?php foreach ($destination_styles as $k => $style):?>
		<a class="list-group-item" href="<?=get_page_url(TOURS_BY_TRAVEL_STYLE_PAGE, $destination, $style)?>">
		<span class="glyphicon glyphicon-chevron-right" style="font-size: 10px; top: 0"></span>
		<?=!is_symnonym_words($style['name']) ? lang_arg('tour_travel_style', $style['name']) : $style['name']?>
		</a>
		<?php endforeach;?>
	</div>
</div>
<?php endif;?>