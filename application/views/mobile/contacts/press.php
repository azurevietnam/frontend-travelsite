<div class="container">
    <div class="bpv-col-left">
    	<?=$mnu_contacts?>
    </div>
    <div class="bpv-col-right about-us">
    	<div class="bpv-contact-container">
    		<div class="content">
                <h2 class="bpv-color-title">BestPrice với báo chí</h2>
                
                <?php if(count($search_news) > 0):?>
                <?php foreach ($search_news as $k => $news):?>
                <div class="row">
                <div class="col-xs-12" <?=$k==0 ? '' : 'style="border-top: 1px dotted #eee; padding-top: 10px; margin-top: 10px"'?>>
                    <?php if(!empty($news['link'])):?>
                    <a href="<?=$news['link']?>" target="_blank" rel="nofollow">
                    <img width="180" src="<?=get_static_resources('/images/news/'.$news['picture'])?>">
                    </a>
                    <?php else:?>
                    <a href="<?=get_url(NEWS_DETAILS_PAGE, $news)?>">
                    <img width="180" src="<?=get_static_resources('/images/news/'.$news['picture'])?>">
                    </a>
                    <?php endif;?>
                    
                    <?php if(!empty($news['link'])):?>
                    <h5 class="bpv-color-title" style="font-size: 16px">
                    <a href="<?=$news['link']?>" target="_blank" rel="nofollow"><?=$news['name']?></a>
                    </h5>
		            <?php else:?>
		            <a href="<?=get_url(NEWS_DETAILS_PAGE, $news)?>"><?=$news['name']?></a>
		            <?php endif;?>
		
		            <div style="color: #666; display: block; margin: 10px 0 5px;"><?=$news['source']?></div>
        			<?php if(!empty($news['short_description'])):?>
        			<?=$news['short_description']?>
        			<?php endif;?>
                </div>
                </div>
                <?php endforeach;?>
                
                <div class="col-xs-12 text-right">
        			<?=str_replace("&amp;", "?", $paging_info['paging_links'])?>
        			
        			<div class="paging-text">
        				<?=$paging_info['paging_text']?>
        			</div>
        		</div>
                <?php endif;?>
    		</div>
        </div>
    </div>
</div>