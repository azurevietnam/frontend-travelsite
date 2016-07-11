<h2 class="text-highlight"><span class="icon icon-recommend"></span><?=$recommended_title?></h2>
<div id="tabs" class="bpt-tab bpt-tab-tours" role="tabpanel">
    <ul class="nav nav-tabs" role="tablist">
    <?php $cnt = 0?>
    <?php foreach ($cruise_types as $key => $value):?>
        <?php if(count($cruise_types) >= 7 && $cnt == 5) break;?>
        <li role="presentation" <?php if($value['is_first']):?>class="active"<?php endif;?>>
        <a href="#page_<?=$key?>" aria-controls="page_<?=$key?>" role="tab" data-toggle="tab"><?=lang($value['label'])?></a>
        </li>
        <?php $cnt++?>
    <?php endforeach;?>
    
    <?php if(count($cruise_types) >= 7):?>
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <?=lang('more')?> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <?php $cnt = 0?>
            <?php foreach ($cruise_types as $key => $value):?>
            <?php $cnt++?>
            <?php if($cnt < 6) continue?>
            <li role="presentation" <?php if($value['is_first']):?>class="active"<?php endif;?>>
            <a href="#page_<?=$key?>" aria-controls="page_<?=$key?>" role="tab" data-toggle="tab"><?=lang($value['label'])?></a>
            </li>
            <?php endforeach;?>
        </ul>
      </li>
    <?php endif;?>
    </ul>
</div>

<div class="tab-content">
<?php $cnt = 0?>
<?php foreach ($cruise_types as $key => $value):?>
    <div  role="tabpanel" class="tab-pane <?php if($value['is_first']):?>active<?php endif;?>" id="page_<?=$key?>">
        <?php if(count($cruise_types) >= 7 && $cnt >= 5):?>
        <h3 class="text-highlight margin-top-10"><?=lang($value['label'])?></h3>
        <?php endif;?>
    
        <?=$value['list_cruises']?>
        <div class="pull-right margin-top-10">
            <a href="<?=site_url($value['type'])?>" class="bpt-see-more"><?=lang($value['more_lang'])?><span class="icon icon-arrow-right-blue-sm margin-left-5"></span></a>
        </div>
    </div>
<?php $cnt++?>
<?php endforeach;?>
</div>
<script type="text/javascript">
	load_arrow_offer('#page_luxuryhalongcruises .bpt-item', true);
	
	$('#tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		load_arrow_offer('.active .bpt-item', true);
	})
</script>