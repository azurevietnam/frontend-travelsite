<div class="list-all-cruises">
    <div class="container">
        <?php foreach($cruise_types as $key => $value):?>
        
        <?php if(!empty($value['cruises'])):?>
        <h3><a class="text-highlight" href="<?=get_page_url($key)?>"><?=lang($value['full_label'])?></a></h3>
        
        <div class="row">
            <?php foreach ($value['cruises'] as $cruise):?>
            
            <div class="col-xs-3 margin-bottom-5">
            <span class="text-special arrow-orange margin-right-5">&rsaquo;</span>
            <a href="<?=get_page_url(CRUISE_DETAIL_PAGE, $cruise)?>"><?=$cruise['name']?></a>
            <?php if($cruise['is_new'] == 1):?>
        		<span class="text-special">&nbsp;<?=lang('obj_new')?></span>
        	<?php endif;?>
            </div>
            
            <?php endforeach;?>      
        </div>
        <?php endif;?>
        
        <?php endforeach;?>
    </div>
</div>