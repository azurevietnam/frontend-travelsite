<?php if(!empty($itineraries)):?>
<div class="itinerary-overview margin-bottom-20">
	<h2 class="title text-highlight"><?=lang('lbl_tour_summary')?></h2>
	<ul>
	    <?php foreach ($itineraries as $k => $value):?>
        <li class="nav-itinerary-pr<?=$k == 0 ? ' active' : '';?>">
            <a class="nav-itinerary" name="itinerary_details_<?=$value['id'].'_'.$k?>">
            <?=get_icon_transportation($value['transportations'], true)?>
            <?=$value['label']?>: <?=character_limiter($value['title'], 30)?><span class="arrow-it"></span>
            </a>
        </li>
        <?php endforeach;?>
	</ul>
</div>
<?php endif;?>