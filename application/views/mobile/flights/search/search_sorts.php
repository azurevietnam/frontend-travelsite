	<ul class="nav nav-pills nav-stacked">
		<?php foreach ($sort_by as $key=>$value):?>
		
			<li id="sort_by_<?=$value['value']?>" <?php if($value['selected']):?>class="active"<?php endif;?>>
		    	<a href="javascript:void(0)" onclick="sort_flight_by('<?=$value['value']?>')" style="white-space:nowrap;">
		    		<?=$value['label']?>
		    	</a><i class="glyphicon glyphicon-ok"></i>
	        </li>
			
		<?php endforeach;?>
        
    </ul>
