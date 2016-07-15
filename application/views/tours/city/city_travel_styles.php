<?php if(!empty($travel_styles)):?>
<h2 class="text-highlight margin-top-30"><span class="icon icon-recommend"></span><?=lang_arg('title_recommend_tours_of_destination', $destination['name'])?></h2>
<div id="tabs" class="bpt-tab bpt-tab-tours" role="tabpanel">
    <ul class="nav nav-tabs" role="tablist">
    <?php foreach ($travel_styles as $key => $value):?>
        <?php if(empty($value['list_tours'])) continue;?>
        <?php if(count($travel_styles) >= 7 && $key == 5) break;?>
        
        <li role="presentation" <?php if($key==0):?>class="active"<?php endif;?>>
        <a href="<?='#'.strtolower($value['url_title'])?>" aria-controls="<?=strtolower($value['url_title'])?>" role="tab" data-toggle="tab">
        <?=!is_symnonym_words($value['name']) ? lang_arg('tour_travel_style', $value['name']) : $value['name']?>
        </a>
        </li>
    <?php endforeach;?>
    
    <?php if(count($travel_styles) >= 7):?>
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <?=lang('more')?> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <?php foreach ($travel_styles as $key => $value):?>
            <?php if($key < 5 || empty($value['list_tours'])) continue?>
            <li role="presentation" <?php if($key==0):?>class="active"<?php endif;?>>
            <a href="<?='#'.strtolower($value['url_title'])?>" aria-controls="<?=strtolower($value['url_title'])?>" role="tab" data-toggle="tab">
            <?=!is_symnonym_words($value['name']) ? lang_arg('tour_travel_style', $value['name']) : $value['name']?>
            </a>
            </li>
            <?php endforeach;?>
        </ul>
      </li>
    <?php endif;?>
    </ul>
</div>

<div class="tab-content pull-left bpt-item-background">
	<?php foreach ($travel_styles as $key => $value):?>
	
	<?php if(empty($value['list_tours'])) continue;?>
	
    <div role="tabpanel" class="tab-pane <?php if($key==0):?>active<?php endif;?>" id="<?=strtolower($value['url_title'])?>">
    
        <?php if(count($travel_styles) >= 7 && $key >= 5):?>
        <?php $style_name = !is_symnonym_words($value['name']) ? lang_arg('tour_travel_style', $value['name']) : $value['name'];?>
        <h3 class="text-highlight"><?=$style_name?></h3>
        <?php endif;?>
  		
  		<?=$value['list_tours']?>
		
		<div class="pull-right margin-top-10">
  		    <a class="bpt-see-more" href="<?=get_page_url(TOURS_BY_TRAVEL_STYLE_PAGE, $destination, $value)?>">
  		    <?=lang_arg('more_name_tour', $destination['name'] . ' '. $value['name'])?>
  		    <span class="icon icon-arrow-right-blue-sm margin-left-5"></span>
  		    </a>
  		</div>
	</div>
	<?php endforeach;?>
</div>
<?php endif;?>