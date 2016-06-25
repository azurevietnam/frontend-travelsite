<?=$bpv_ads?>
<div class="container">
    <?=$bpv_search?>
    
    <div class="margin-top-20">
    	<?=load_bpv_call_us(HOTEL)?>
    </div>

</div>

<?=$bpv_popular_tours?>

<div class="container">
    <div class="bpv-box">
        <h3 class="box-heading no-margin"><?=lang('halong_popular_cruises')?></h3>

		<div class="list-group bpv-list-group">
	        <span class="list-group-item group-title bpv-color-title"><?=lang('luxury_cruises')?></span>
    	    <?php foreach ($popular_cruises as $k => $cruise):?>
    		<?php if($cruise['star'] >= 4):?>
    		<a class="list-group-item<?=($k==0) ? ' no-border' : ''?>" href="<?=cruise_build_url($cruise, $search_criteria)?>">
			    <i class="icon icon-arrow-right-blue"></i>
				<?=$cruise['name']?>
				<i class="icon star-<?=str_replace('.', '_', $cruise['star'])?>"></i>
			</a>
    		<?php endif;?>
    		<?php endforeach;?>

    		<span class="list-group-item group-title bpv-color-title"><?=lang('budget_cruises')?></span>
    		<?php $cnt=0;?>
    	    <?php foreach ($popular_cruises as $k => $cruise):?>
		    <?php if($cruise['star'] < 4):?>
    		<a class="list-group-item<?=($cnt==0) ? ' no-border' : ''?>" href="<?=cruise_build_url($cruise, $search_criteria)?>">
			    <i class="icon icon-arrow-right-blue"></i>
				<?=$cruise['name']?>
				<i class="icon star-<?=str_replace('.', '_', $cruise['star'])?>"></i>
			</a>
			<?php $cnt++;?>
    		<?php endif;?>
    		<?php endforeach;?>
	    </div>
	</div>
</div>