<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h2 class="highlight" style="padding: 10px 10px 0"><span class="icon icon_hotel" style="margin-top: 2px;"></span><?=lang('hotel_top_destination')?></h2>
<div style="padding:0 10px 10px">
<?php $count=0;?>
<?php foreach ($top_dess as $key => $value):?>
	<div class="desData">
		<ul>
    			<li>
    				<a class="des" title="<?=$value['name'].' '.ucfirst(lang('hotels'))?>" href="<?=url_builder(MODULE_HOTELS, $value['url_title'] . '-' .MODULE_HOTELS)?>">
                		<?=$value['name']?>  <?=ucfirst(lang('hotels')) ?></a>
    			</li>
    			<li><label><b><?=$value['number_hotels']?></b> <?=lang('hotels') ?></label></li>
    	</ul>
	</div>
<?php $count++;?>
<?php endforeach;?>
</div>
