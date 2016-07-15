<?php if(!empty($highlights)):?>
    
    <div class="trip-highlight-content">
    <?php foreach ($highlights as $k => $value):?>
        <div class="ih-row<?=$k>2 ? ' ih-row-more' : ''?>"<?=$k>2 ? ' style="display:none"' : ''?>>
            <div class="ih-title text-highlight">
                <div class="ih-day"><?=$value['label']?>:</div><div><?=$value['title']?></div>
            </div>

            <?php if(!empty($value['content'])):?>
            <?php $tour_highlights = explode("\n", $value['content']);?>
            <ul class="clearfix">
                <?php foreach ($tour_highlights as $hl_value):?>
        			<?php if(!empty($hl_value)):?>
        			<li class="margin-bottom-5"><span><?=format_object_overview($hl_value)?></span></li>
        			<?php endif;?>
        		<?php endforeach;?>
            </ul>
        </div>
        <?php endif;?>
    <?php endforeach;?>
    
    <?php if(count($highlights) > 2):?>
    <div class="text-right margin-bottom-10">
        <a href="javascript:void()" id="btn_show_more_ih" style="text-decoration: underline;" 
        data-lang-more="<?=lang('label_show_more')?>" data-lang-less="<?=lang('label_show_less')?>">
        <span class="pl-text"><?=lang('label_show_more')?></span><span class="icon icon-arrow-right-blue-sm margin-left-5"></span>
        </a>
    </div>
    <?php endif;?>
    </div>

<?php else:?>

    <?php $tour_highlights = explode("\n", $tour['tour_highlight']);?>

    <?php if(!empty($tour_highlights)):?>
	<ul class="tour-highlight clearfix">
		<?php foreach ($tour_highlights as $value):?>
			<?php if(!empty($value)):?>
			<li class="margin-bottom-10"><span class="icon icon-check"></span><?=format_object_overview($value)?></li>
			<?php endif;?>
		<?php endforeach;?>
	</ul>
    <?php endif;?>

<?php endif;?>