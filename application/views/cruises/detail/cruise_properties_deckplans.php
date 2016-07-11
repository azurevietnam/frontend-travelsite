<div class="margin-top-20 cruise-properties">
    <h3 class="title text-highlight"><?=lang('cruise_properties_description')?><span id="lb_cruise_name"></span>:</h3>
    <table class="table-bordered">
    	<thead>
    		<tr>
    			<th class="text-center" width="20%"><?=lang('cruise_specifications')?></th>
    			<?php foreach ($members as $member):?>
    				<th class="text-center"><?=$member['name']?></th>
    			<?php endforeach;?>
    		</tr>
    	</thead>
    	
    	<tbody>
    		<?php foreach ($properties as $property):?>
    			<tr>
    				<td align="center"><?=$property['name']?></td>
    				
    				<?php foreach ($members as $member):?>
    					<?php if (isset($member_properties[$property['id']]) && isset($member_properties[$property['id']][$member['id']])):?>
    						<td align="center"><?=$member_properties[$property['id']][$member['id']]['value']?></td>
    					<?php else:?>
    						<td align="center">
    					<?php endif;?>
    				<?php endforeach;?>
    			</tr>
    			
    		<?php endforeach;?>
    	</tbody>
    </table>
</div>

<?php 
	$has_deck_plan = false;
	
	foreach ($members as $member){
		if (count($member['photos']) > 0){
			$has_deck_plan = true;
			break;
		}
	}

?>
<?php if ($has_deck_plan):?>
<div class="photo-container">		
<?php foreach ($members as $member):?>
	<?php if (count($member['photos']) > 0):?>
	
	<h2 class="text-highlight header-title margin-top-20"><?=lang_arg('label_member_deck_plan', $member['name'])?></h2>
	
	<div class="row">
	<?php foreach ($member['photos'] as $key =>$value) :?>
        <div class="col-xs-4 margin-bottom-10">
            <a rel="nofollow" href="<?=get_image_path(PHOTO_FOLDER_CRUISE, $value['name'], 'mediums')?>" 
                data-lightbox="photo_deck_plan" data-title="<?=$value['description']?>">
            <img width="220" height="165" src="<?=get_image_path(PHOTO_FOLDER_CRUISE, $value['name'], 'mediums')?>">
            </a>
            <div class="text-center"><b><?=$value['description']?></b></div>
        </div>
	<?php endforeach;?>
	</div>
	
	<?php endif;?>	
<?php endforeach;?>
</div>
<?php endif;?>