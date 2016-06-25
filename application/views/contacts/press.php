<div class="container">
    <div class="bpv-col-left">
    	<?=$mnu_contacts?>
    </div>
    <div class="bpv-col-right about-us">
    	<div class="bpv-contact-container">
    		<div class="content">
                <h2 class="bpv-color-title">BestPrice với báo chí</h2>
                <table>
                    <?php foreach ($search_news as $k => $news):?>
                    <tr>
                        <td class="accomplish_left" style="width: 180px; padding-left: 0">
                            <?php if(!empty($news['link'])):?>
                            <a href="<?=$news['link']?>" target="_blank" rel="nofollow">
                            <img width="180" src="<?=get_static_resources('/images/news/'.$news['picture'])?>">
                            </a>
                            <?php else:?>
                            <a href="<?=get_url(NEWS_DETAILS_PAGE, $news)?>">
                            <img width="180" src="<?=get_static_resources('/images/news/'.$news['picture'])?>">
                            </a>
                            <?php endif;?>
                        </td>
                        <td class="accomplish_right" valign="top">
                            <?php if(!empty($news['link'])):?>
                            <h5 class="bpv-color-title no-margin" style="font-size: 16px">
                            <a href="<?=$news['link']?>" target="_blank" rel="nofollow"><?=$news['name']?></a>
                            </h5>
    			            <?php else:?>
    			            <a href="<?=get_url(NEWS_DETAILS_PAGE, $news)?>"><?=$news['name']?></a>
    			            <?php endif;?>
    			
    			            <div style="color: #666; display: block; margin: 10px 0 5px;"><?=$news['source']?></div>
                			<?php if(!empty($news['short_description'])):?>
                			<?=$news['short_description']?>
                			<?php endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div style="border-top: 1px solid #eee"></div>
                        </td>
                    </tr>
                    <?php endforeach;?>
                    
                    <?php if(count($search_news) > 0):?>
                    <tr>
                        <td colspan="2">
                    	    <div class="pull-right margin-top-20" style="width: 100%">
                    			<?=str_replace("&amp;", "?", $paging_info['paging_links'])?>
                    			
                    			<div class="paging-text">
                    				<?=$paging_info['paging_text']?>
                    			</div>
                    		</div>
                        </td>
                    </tr>
                    <?php endif;?>
                </table>  
    		</div>
        </div>
    </div>
</div>