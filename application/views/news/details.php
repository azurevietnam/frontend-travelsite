<div class="container main-content">

    <ol class="breadcrumb">
        <li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
        <li><a href="<?=site_url(NEWS_HOME_PAGE)?>"><?=lang('mnu_news')?></a></li>
        
        <?php if(!empty($selected_category)):?>
        <?php
            $obj = array(
                'id' => $selected_category['id'],
                'url_title' => url_title(convert_unicode($selected_category['name']), '-', true)
            );
        ?>
        <li><a href="<?=get_url(NEWS_CATEGORY_PAGE, $obj)?>"><?=$selected_category['name']?></a></li>
        <?php endif;?>
        
        <li class="active"><?=$news['name']?></li>
	</ol>
	
	<div class="bpv-col-left">
		<?=$side_menu?>
	</div>
	
	<div class="bpv-col-right">
	
		<div class="flight-content">
			<h1 class="bpv-color-title no-margin"><?=$news['name']?></h1>
			
			<?php if(!empty($news['short_description'])):?>
			<div class="margin-top-10 margin-bottom-20">
			<b><?=$news['short_description']?></b>
			</div>
			<?php endif;?>
			
			<div class="margin-top-10 margin-bottom-20">
				<?=$news['content']?>
			</div>
		</div>
		
		<?php if (!empty($related_news)):?>
        <div class="related-news">
        	<h5 class="bpv-color-title"><?=lang('related_news')?></h5>
        	
        	<?php 
        		$new_types = array('hotel', 'flight', 'cruise', 'tour', 'general');
        		
        		$priority = null;
        		switch ($news['type']) {
        			case M_FLIGHT:
        				$priority = 'flight';
        				break;
        			case M_HOTEL:
        				$priority = 'hotel';
        				break;
        			case M_CRUISE:
        				$priority = 'cruise';
        				break;
        			case M_TOUR:
        				$priority = 'tour';
        				break;
        		}
        		
        		if(!empty($priority)) $types[] = $priority;
        		
        		foreach ($new_types as $type) {
        			if($priority != $type)
        				$types[] = $type;
        		}
        	?>
        	
        	<?php foreach ($types  as $type):?>
        	
        	<?php if(isset($related_news[$type])):?>
        	<h6 class="bpv-color-title no-margin margin-top-20 margin-bottom-5"><?=lang('related_news_'.$type)?></h6>
        	<ul class="list-orange">
        		
        		<?php foreach ($related_news[$type]  as $r_news):?>
        		<li class="margin-bottom-5"><a href="<?=get_url(NEWS_DETAILS_PAGE, $r_news)?>"><?=$r_news['name']?></a></li>
        		<?php endforeach;?>
        		
        	</ul>
        	<?php endif;?>
        	
        	<?php endforeach;?>
        
        </div>
        <?php endif;?>
		
	</div>
	
</div>

<?=$bpv_register?>