<?php if(!empty($cruise_types)):?>
<div class="travel-styles clearfix margin-bottom-10">
    <h2 class="text-highlight line-border">
    <span class="icon icon-cruise-green margin-right-5"></span><?=lang_arg('title_cruise_travel_style', 'Mekong')?>
    </h2>
    	
    	<?php $cnt = 0;?>
        <?php foreach ($cruise_types as $key => $value):?>
        <?php if(!$value['show_on_styles']) continue;?>
        
        <?php if($cnt == 0):?>
        <div class="row">
        <?php elseif ($cnt%4 == 0 && $cnt > 0):?>
        </div><div class="row">
        <?php endif;?>
        
        <div class="col-xs-3">
            <a href="<?=get_page_url($key)?>">
            <img width="180" height="120" alt="<?=lang($value['style_label'])?>" src="<?=get_static_resources('/media/cruise_styles/'.$key.'.jpg')?>">
            </a>
            
            <div class="clearfix item-style">
                <a href="<?=get_page_url($key)?>"><?=lang($value['style_label'])?></a>
                <p <?=set_tooltip(lang($value['style_desc']), 60)?>><?=character_limiter(lang($value['style_desc']), 60)?></p>
            </div>
        </div>
        
        <?php $cnt++;?>
        <?php endforeach;?>
        
        <div class="col-xs-6 more-des-ts">
            <h4 class="text-special"><?=lang('lbl_more_destination_travel_styles')?>:</h4>
            <?php foreach ($cruise_types as $key => $value):?>
            <?php if($value['show_on_styles']) continue;?>
            <div class="col-xs-6 padding-left-0 margin-bottom-5">
            <label class="text-special">&rsaquo;</label>
            <a href="<?=get_page_url($key)?>"><?=lang($value['style_label'])?></a>
            </div>
            <?php endforeach;?>
        </div>
        
        </div>
</div>
<script>
//set tooltip
var options = { placement: 'top' }
$('[data-toggle="tooltip"]').tooltip(options);
</script>
<?php endif;?>