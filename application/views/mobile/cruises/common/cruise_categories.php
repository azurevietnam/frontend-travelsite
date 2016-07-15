<?php if(!empty($cruise_types)):?>
<div class="container">
<div class="bpv-box margin-top-20">
    <h3 class="box-heading no-margin"><?=lang('find_your_cruises')?></h3>
	<div class="list-group bpv-list-group">
        <a class="list-group-item <?=$page==$main_page ? 'active': ''?>" href="<?=get_page_url($main_page)?>">
        <span class="glyphicon glyphicon-chevron-right" style="font-size: 10px; top: 0"></span>
        <?=strpos($page, 'halong') !== FALSE ? lang('label_all_halong_cruise_categories') : lang('label_all_mekong_cruise_categories')?>
        </a>
        
        <?php foreach($cruise_types as $key=>$value):?>
        
        <a class="list-group-item <?=$page==$key ? 'active': ''?>" href="<?=get_page_url($key)?>">
        <span class="glyphicon glyphicon-chevron-right" style="font-size: 10px; top: 0"></span>
        <?=lang($value['label'])?>
        </a>
        
		<?php endforeach;?>
	</div>
</div>
</div>
<?php endif;?>