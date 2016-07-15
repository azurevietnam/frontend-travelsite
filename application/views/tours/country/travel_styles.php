<?php if(!empty($destination_styles)):?>
<div class="travel-styles margin-top-20 margin-bottom-30">
    <h2 class="text-highlight line-border"><span class="icon icon-discover"></span><?=lang_arg('title_vn_tour_by_travel_style', $destination['name'])?></h2>
    <div class="row">
        <?php foreach ($destination_styles as $k => $style):?>
        <?php if($k > 5) break;?>
        <div class="col-xs-3<?=$k<4 ? ' margin-bottom-5' : ''?>">
            <a href="<?=get_page_url(TOURS_BY_TRAVEL_STYLE_PAGE, $destination, $style)?>">
            <?php if(!empty($style['picture'])):?>
                <img width="195" height="130" alt="<?=$style['name']?>" src="<?=get_image_path(PHOTO_FOLDER_DESTINATION_TRAVEL_STYLE, $style['picture'], '195_130')?>">
            <?php elseif(!empty($style['style_picture'])):?>
                <img width="195" height="130" alt="<?=$style['name']?>" src="<?=get_image_path(PHOTO_FOLDER_TRAVEL_STYLE, $style['style_picture'], '195_130')?>">
            <?php else:?>
                <img width="195" height="130" alt="<?=$style['name']?>" src="<?='/media/vietnam_tour/'.strtolower(url_title($style['name'], '_')).'.jpg'?>">
            <?php endif;?>
            </a>
            
            <div class="clearfix item-style">
                <a href="<?=get_page_url(TOURS_BY_TRAVEL_STYLE_PAGE, $destination, $style)?>">
                    <?=!is_symnonym_words($style['name']) ? lang_arg('tour_travel_style', $style['name']) : $style['name']?>
                </a>
                <?php $style_description = !empty($style['description']) ? $style['description'] : $style['style_description']?>
                <p <?=set_tooltip($style_description, 60)?>><?=character_limiter($style_description, 60)?></p>
            </div>
        </div>
        <?php endforeach;?>
        <?php if(count($destination_styles) > 6):?>
        <div class="col-xs-6 more-des-ts">
            <h4 class="text-special"><?=lang('lbl_more_destination_travel_styles')?>:</h4>
            <?php foreach ($destination_styles as $k => $style):?>
            <?php if($k < 6) continue;?>
            <div class="col-xs-6 padding-left-0 margin-bottom-5">
            <label class="text-special">&rsaquo;</label>
            <a href="<?=get_page_url(TOURS_BY_TRAVEL_STYLE_PAGE, $destination, $style)?>">
            <?=!is_symnonym_words($style['name']) ? lang_arg('tour_travel_style', $style['name']) : $style['name']?>
            </a>
            </div>
            <?php endforeach;?>
        </div>
        <?php endif;?>
    </div>
</div>
<?php endif;?>