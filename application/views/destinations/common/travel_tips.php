<div class="mg-top-20">
    <?php if (!empty($destination['travel_tips'])):?> 
	    <h2 class="highlight"><b><?=lang('overview_travel_tip', $destination['name'])?></b></h2>
	    <!-- 
	    <ol>
	        <?php foreach($destination['travel_tips'] as $value):?>
	            <li><?=$value?></li>
	        <?php endforeach;?>
	    </ol>
	   	-->
	    <div>
	    	<?=$destination['travel_tips']?>
	    </div>
	     
    <?php endif;?>
</div>
