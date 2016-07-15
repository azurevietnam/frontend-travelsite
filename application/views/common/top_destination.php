<div id="topTourDestinations" class="grayBox">
	<h2 class="highlight"><span class="icon icon_location"></span><?=lang('top_destination')?></h2>
	<div class="content">
		<?php foreach ($parent_dess as $key => $parent_des):?>
			<?php $count=0;?>
			<div class="desCountry">
				<?php if($parent_des['id'] == VIETNAM):?>
					<a href="<?=url_builder('',TOUR_HOME)?>"><?=$parent_des['name']?> <?=ucfirst(lang('tours'))?></a>
				<?php else:?>
					<a href="<?=url_builder(MODULE_TOURS, $parent_des['url_title'].'-' .MODULE_TOURS)?>"><?=$parent_des['name']?> <?=ucfirst(lang('tours'))?></a>
				<?php endif;?>
			</div>
			<?php for ($i = 0; $i < count($dess); ++$i) :?>
				<?php if($dess[$i]['parent_id'] != $parent_des['id']) continue;?>
		    	<div class="desData">
		    		<ul>
		    			<li>
		    				<a class="des" title="<?=$dess[$i]['name']?>" 
	                			href="<?=url_builder(MODULE_TOURS, $dess[$i]['url_title'] . '-' .MODULE_TOURS)?>">
	                			<?=$dess[$i]['name']?> <?=ucfirst(lang('tours'))?></a>
		    			</li>
		    			<li><label><b><?=$dess[$i]['number_tours']?></b> <?=strtolower(ucfirst(lang('number_of_tours')))?></label></li>
		    		</ul>
		        </div>
		        <?php $count++;?>
		    <?php endfor;?>
		<?php endforeach;?>
	</div>
</div>