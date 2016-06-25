<div class="container">
    <ol class="breadcrumb">
	  <li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
	  <li><a href="<?=site_url(TOUR_HOME_PAGE).'/'?>"><?=lang('mnu_tours')?></a></li>
	  <li class="active"><?=lang('search_suggestion')?></li>
	</ol>
	
	<h1>
		<?php if(isset($no_suggestion)):?>
			<?=lang('no_search_results_of_keyword')?>
		<?php else:?>
			<?=lang('search_results_of_keyword')?>
		<?php endif;?> 
		<span class="bpv-color-title"><?=$search_criteria['destination']?></span>
	</h1>

    <div class="row margin-top-20" style="margin-bottom: 60px">
    
        <div class="col-xs-4">
            <div class="bpv-tour-destination">
                <div class="bpv-color-title title">
                	<span class="icon icon-hotel"></span><a class="bpv-color-title" href="<?=site_url(TOUR_DOMESTIC_PAGE)?>"> <?=lang('label_domestic_tours')?></a>
                </div>
            
                <?php foreach ($domestic_destinations as $k => $des):?>
                <div class="group-name" data-target="<?='#group_'.$des['url_title']?>"><?=$des['name']?></div>
                
                <?php if(!empty($des['destinations'])):?>
                <ul class="list-unstyled" id="<?='group_'.$des['url_title']?>">
                
                <li><a href="<?=get_url(TOUR_DESTINATION_PAGE, $des)?>"><?=lang('label_departing').$des['name']?></a></li>
                   
                   <?php foreach ($des['destinations'] as $highlight_des):?>
                   <li><a href="<?=get_url(TOUR_DESTINATION_PAGE, $highlight_des)?>"><?=$highlight_des['name']?></a></li>
                   <?php endforeach;?>
                </ul>
                <?php endif;?>
                
                <?php endforeach;?>
            
            </div>
        </div>
        
        <div class="col-xs-4">
            <div class="bpv-tour-destination">
                <div class="bpv-color-title title">
                	<span class="icon icon-hotel"></span><a class="bpv-color-title" href="<?=site_url(TOUR_OUTBOUND_PAGE)?>"> <?=lang('label_outbound_tours')?></a>
                </div>
               
                <?php foreach ($outbound_destinations as $k => $des):?>
                <div class="group-name" data-target="<?='#group_'.$des['url_title']?>"><?=$des['name']?></div>
                
                <?php if(!empty($des['destinations'])):?>
                <ul class="list-unstyled" id="<?='group_'.$des['url_title']?>">
                
                <li><a href="<?=get_url(TOUR_DESTINATION_PAGE, $des)?>"><?=lang('label_departing').$des['name']?></a></li>
                   
                   <?php foreach ($des['destinations'] as $highlight_des):?>
                   <li><a href="<?=get_url(TOUR_DESTINATION_PAGE, $highlight_des)?>"><?=$highlight_des['name']?></a></li>
                   <?php endforeach;?>
                </ul>
                <?php endif;?>
                
                <?php endforeach;?>
               
            </div>
        </div>
        
        <div class="col-xs-4">
            <div class="bpv-tour-destination">
                <div class="title">
                	<span class="icon icon-hotel"></span><a class="bpv-color-title" href="<?=site_url(TOUR_CATEGORY_PAGE)?>"> <?=lang('label_category_tours')?></a>
                </div>
                <ul class="list-unstyled">
                    <?php foreach ($tour_categories as $cat):?>    
                	<li>
                	   <a href="<?=get_url(TOUR_CATEGORY_DETAIL_PAGE, $cat)?>">
                	       <?=$cat['name']?>
                	       <?php if($cat['is_hot']):?>
                	       <img src="<?=get_static_resources('/media/icon/icon-hot.png')?>">
                	       <?php endif;?>
                	   </a>
                	</li>
                	<?php endforeach;?>
                </ul>
            </div>
        </div>
    </div>

</div>

<?=$bpv_register?>

<script>
$('.group-name').bpvToggle();
</script>