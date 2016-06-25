<div class="container main-content">

	<ol class="breadcrumb">
        <li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
        <?php if(isset($selected_category)):?>
        <li><a href="<?=get_url(NEWS_HOME_PAGE)?>"><?=lang('mnu_news')?></a></li>
        <li class="active"><?=$selected_category['name']?></li>
        <?php else:?>
        <li class="active"><?=lang('mnu_news')?></li>
        <?php endif;?>
	</ol>
	
	<div class="bpv-col-left">
        <?=$side_menu?>
	</div>
	
	<div class="bpv-col-right">
	
	    <h1 class="bpv-color-title" style="margin-top: 0"><?=$news_header?></h1>
	    
	    <div class="news-box">
            
            <?php if(!empty($first_news)): ?>
            <div class="main-box">
            	<?php if(count($first_news) > 1):?>
                <div class="col-left" style="position: relative;">
                    <?php if(!empty($first_news[0]['link'])):?>
                    <a href="<?=$first_news[0]['link']?>" target="_blank" rel="nofollow">
                    <img class="img-responsive" src="<?=get_static_resources('/images/news/'.$first_news[0]['picture'])?>">
                    </a>
                    <div class="first-item">
                        <a href="<?=$first_news[0]['link']?>" target="_blank"><?=$first_news[0]['name']?></a>
                        
                        <?=$first_news[0]['short_description']?>
                    </div>
                    <?php else:?>
                    <a href="<?=get_url(NEWS_DETAILS_PAGE, $first_news[0])?>">
                    <img class="img-responsive" src="<?=get_static_resources('/images/news/'.$first_news[0]['picture'])?>">
                    </a>
                    <div class="first-item">
                        <a href="<?=get_url(NEWS_DETAILS_PAGE, $first_news[0])?>"><?=$first_news[0]['name']?></a>
                        
                        <?=$first_news[0]['short_description']?>
                    </div>
                    <?php endif;?>
                    
                </div>
                <?php endif;?>
                
                <?php if(count($first_news) > 2):?>
                <div class="col-right">
                    <?php foreach ($first_news as $key => $news):?>
                    <?php if($key == 0) continue;?>
                    <div class="news-item-sm">
                        <?php if(!empty($news['link'])):?>
                        <a href="<?=$news['link']?>" target="_blank" rel="nofollow">
                        <img width="60" class="img-responsive" src="<?=get_static_resources('/images/news/'.$news['picture'])?>">
                        <?=$news['name']?>
                        </a>
                        <?php else:?>
                        <a href="<?=get_url(NEWS_DETAILS_PAGE, $news)?>">
                        <img width="60" class="img-responsive" src="<?=get_static_resources('/images/news/'.$news['picture'])?>">
                        <?=$news['name']?>
                        </a>
                        <?php endif;?>
                    </div>
                    <?php endforeach;?>
                </div>
                <?php endif;?>
            </div>
            <?php endif;?>
            
            
            <?php foreach ($search_news as $key => $news):?>
            	
                <div class="news-item">
                    <div class="col-xs-3 pd-left-0 pd-right-0">
                        <?php if(!empty($news['link'])):?>
                        <a href="<?=$news['link']?>" target="_blank" rel="nofollow">
                        <img class="img-responsive" src="<?=get_static_resources('/images/news/'.$news['picture'])?>">
                        </a>
                        <?php else:?>
                        <a href="<?=get_url(NEWS_DETAILS_PAGE, $news)?>">
                        <img class="img-responsive" src="<?=get_static_resources('/images/news/'.$news['picture'])?>">
                        </a>
                        <?php endif;?>
                    </div>
                    <div class="col-xs-9">
    					<h4 class="bpv-color-title">
    					   <?php if(!empty($news['link'])):?>
    					   <a href="<?=$news['link']?>" target="_blank" rel="nofollow"><?=$news['name']?></a>
    					   <?php else:?>
    					   <a href="<?=get_url(NEWS_DETAILS_PAGE, $news)?>"><?=$news['name']?></a>
    					   <?php endif;?>
    					</h4>
    					
    					<?php if(!empty($news['link']) && !empty($news['source'])):?>
    					<div class="publish-date"><?=$news['source']?></div>
    					<?php else:?>
    					<div class="publish-date"><?=date(NEWS_DATE_FORMAT, strtotime($news['date_created']))?></div>
    					<?php endif;?>
    					<?=$news['short_description']?>
    				</div>
    		    </div>
    		<?php endforeach;?>
	    </div>
	    
	    <?php if(count($search_news) > 0):?>
	    <div class="pull-right margin-top-20">
			<?=str_replace("&amp;", "?", $paging_info['paging_links'])?>
			
			<div class="paging-text">
				<?=$paging_info['paging_text']?>
			</div>
		</div>
	    <?php endif;?>
	</div>

</div>

<?=$bpv_register?>