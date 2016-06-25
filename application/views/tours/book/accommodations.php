<div class="room-types margin-bottom-20">
    <div class="bpv-rate-table">
    	<table>
    		<thead>
    			<tr>
    				<td class="col-1" align="left"><?=lang('class_name')?></td>
    				<td class="col-3" align="center"><?=lang('class_price')?></td>
    			</tr>			
    		</thead>
    		<tbody>
    			
    			<?php foreach ($accommodations as $key => $acc):?>
    			
    			<tr <?php if($key > ($accommodation_limit - 1)):?>class="more-rooms" style="display:none;"<?php endif;?>>
    				<td>
						<div class="room-name margin-bottom-10 bpv-color-title"><?=$acc['name']?></div>
						<p><?=$acc['content']?></p>
					</td>
    				
    				<?php if($key == 0):?>
    				<td rowspan="<?=count($accommodations)?>" class="col-rate" align="center">
    					<span class="icon icon-arrow-top"></span>
    					<br><br>
    					<span>(<?=lang('check_rate_title')?>)</span>
    				</td>
    				<?php endif;?>
    			</tr>
    			
    			<?php endforeach;?>
    			
    		</tbody>
    	</table>
    	
    	<?php if(count($accommodations) > $accommodation_limit):?>
    	
    		<div class="view-mores">
    			<span>
    				<a id="show_more_rooms" href="javascript:void(0)" show="hide" onclick="show_more_rooms()"><?=lang('view_more_tour_accom')?></a>
    			</span>
    		</div>
    	
    	<?php endif?>
    </div>
</div>
