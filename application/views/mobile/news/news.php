<div class="container">

	<?=$bpv_search?>

	<h1 class="bpv-color-title"><?=$news['name']?></h1>
	<div class="margin-top-10 margin-bottom-20">
	
        <?php if($news['id'] == 13):?>
            
            <?=$this->load->view('mobile/news/marketing_golden_week', array('news'=>$news))?>
    	
    	<?php elseif($news['id'] == 15):?>
            
            <?=$this->load->view('mobile/news/more_people_more_fun', array('news'=>$news))?>	
            
        <?php else:?>
    	
            <?=$news['content']?>
		      
		<?php endif;?>
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