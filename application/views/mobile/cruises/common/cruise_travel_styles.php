<?php if(!empty($cruise_types)):?>
<div class="container">
<div class="bpv-box margin-top-20 margin-bottom-20">
    <h3 class="box-heading no-margin"><?=lang_arg('title_cruise_travel_style', 'Mekong')?></h3>
	<div class="list-group bpv-list-group">
        <?php foreach ($cruise_types as $key => $value):?>
        <?php if(!$value['show_on_styles']) continue;?>
        
        <a class="list-group-item" href="<?=get_page_url($key)?>">
        <span class="glyphicon glyphicon-chevron-right" style="font-size: 10px; top: 0"></span>
        <?=lang($value['style_label'])?>
        </a>
		<?php endforeach;?>
	</div>
</div>
</div>
<?php endif;?>