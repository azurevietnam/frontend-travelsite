<form id="frm_search_filters">
    <?php if($is_show_cruise_facilitiy_filter):?>
    <div class="bpv-filter">
        <div class="title bpv-color-title"><?=lang('cruise_properties')?></div>
    	<div class="content">
            <?php foreach ($cruise_cabins as $key=>$value):?>
        		<?php if($cruise_cabins_nr[$key] > 0):?>
        			<div class="radio margin-bottom-15">
    				    <label>
    				      <input type="radio" <?=set_checkbox('cruise_cabin', $key, $key == 0)?> name="cruise_cabin" id="cruise_cabin_<?=$key?>" value="<?=$key?>" onclick="filter_results()"> 
    				      <?=translate_text($value)?>
    				      (<?=$cruise_cabins_nr[$key]?>)
    				    </label>
    				 </div>
        		<?php endif;?>
        	<?php endforeach;?>
        	
        	<?php foreach ($cruise_properties as $value):?>
    			<div class="checkbox margin-bottom-15">
    			    <label>
    			      <input type="checkbox" name="cruise_properties[]" id="cruise_properties_<?=$value['id']?>" value="<?=$value['id']?>" onclick="filter_results()"> <?=$value['name']?>
    			      (<?=$value['cnt']?>)
    			    </label>
    			 </div>
    		<?php endforeach;?>
    		
    		<?php if($nr_tripple_family_cabin > 0):?>
    			<div class="checkbox margin-bottom-15">
    			    <label>
    			      <input type="checkbox" name="cruise_properties[]" id="cruise_properties_-1" value="-1" onclick="filter_results()"> <?=lang('has_tripple_family_cabin')?>
    			      (<?=$nr_tripple_family_cabin?>)
    			    </label>
    			</div>
    		<?php endif;?>
    	</div>
    </div>
    <?php endif;?>
    
    <?php if(count($activities) > 0):?>
    <div class="bpv-filter">
        <div class="title bpv-color-title"><?=lang('thing_to_do_in', $destination['name'])?></div>
    	<div class="content">
            <?php foreach ($activities as $value):?>
    		<div class="checkbox margin-bottom-15">
    		    <label>
    		      <input type="checkbox" name="activities[]" id="activities_<?=$value['id']?>" value="<?=$value['id']?>" onclick="filter_results()">
    		      <?=$value['name']?>
    		      (<?=$value['cnt']?>)
    		    </label>
    		 </div>
        	<?php endforeach;?>
    	</div>
    </div>
    <?php endif;?>
    
    <?php if(count($travel_styles) > 0):?>
    <div class="bpv-filter">
        <div class="title bpv-color-title"><?=lang('lbl_travel_styles_in', $destination['name'])?></div>
    	<div class="content">
            <?php foreach ($travel_styles as $value):?>
    		<div class="checkbox margin-bottom-15">
    		    <label>
    		      <input type="checkbox" name="des_styles[]" id="des_styles_<?=$value['id']?>" value="<?=$value['id']?>" onclick="filter_results()">
    		      <?=lang('lbl_tours', $value['name'])?>
    		      (<?=$value['cnt']?>)
    		    </label>
    		 </div>
            <?php endforeach;?>
    	</div>
    </div>
    <?php endif;?>
    
    <?php if(count($sub_destinations) > 0):?>
    <div class="bpv-filter">
        <div class="title bpv-color-title"><?=create_sub_destination_label($destination)?></div>
    	<div class="content">
            <?php $cnt = 0;?>
        	<?php foreach ($sub_destinations as $value):?>
        		 <div class="checkbox margin-bottom-15 <?php if($cnt >= 5):?>des-hide<?php endif;?>" <?php if($cnt >= 5):?> style="display: none"<?php endif;?>>
        		    <label>
        		      <input type="checkbox" name="sub_des[]" id="sub_des_<?=$value['id']?>" value="<?=$value['id']?>" onclick="filter_results()"> <?=$value['name']?>
        		      (<?=$value['cnt']?>)
        		    </label>
        		 </div>
        		 
        		 <?php ++$cnt;?>
        	<?php endforeach;?>
        	
        	<?php if($cnt >= 5):?>
        		<div>
        			<span class="glyphicon glyphicon-plus-sign text-special" data-hide="glyphicon-plus-sign" data-show="glyphicon-minus-sign" id="more_attration"></span>
        			<a href="javascript:void(0)" class="attr-show-more" data-show="hide" data-target=".des-hide" data-icon="#more_attration"><?=lang('label_show_more')?></a>
        		</div>
        		
        		<script type="text/javascript">
        
        			set_show_hide('.attr-show-more');
        		
        		</script>
        		
        	<?php endif;?>
    	</div>
    </div>
    <?php endif;?>
    
    <input type="hidden" name="sort" id="tour_sort_by" value="<?=$search_criteria['sort_by']?>">
</form>
