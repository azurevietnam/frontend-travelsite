<?php if( empty($obj) || empty($reviews)):?>
	<div style="font-size: 14px; margin: 20px 10px">
	<?=lang('no_review')?>
	</div>
<?php else:?>
<div id="review_content">
	<h3 class="bpv-color-title"><span class="hide icon icon-review-details"></span><?=lang_arg('review_of', $obj['name'])?></h3>
	<div class="reviews-panel">
		<div id="rev_total">
			<div id="rev_total_score_number">
				<p class="review_text">
					<?=get_review_text($total_score)?>
				</p>
				<div>
					<span id="rsc_total"><?=$total_score?></span>
				</div>
				<p id="rev_out_of">
					<?=lang('rev_out_of').' '.$count_results.' '.lang('rev_txt')?>
				</p>
			</div>
		</div>
		<div class="breakdown_score_wrapper">
			<div class="trip_type">
				<div class="bpv-color-title title"><?=lang('rev_score_types')?></div>
				<ul>
					<?php foreach ($score_types as $type):?>
					<li class="score-type">
						<span class="rdoSet">
							<?=lang($type['name'])?>
						</span>
						<div class="line">
							<div style="width:<?=($type['value']*10).'%'?>;" class="fill"></div>
						</div>
						<span class="compositeCount"><?=$type['value']?></span>
					</li>
					<?php endforeach;?>
				</ul>
			</div>
			<div class="trip_type">
				<div class="bpv-color-title title"><?=lang('rev_score_breakdown')?></div>
				<ul>
					<?php $cnt = 0;?>
					<?php foreach ($score_breakdown as $value):?>
					<?php $is_selected = is_filter_selected($search_criteria, 'review_score', $value['key']);?>
					
					<li <?=($cnt%2) == 0 ? 'class="even"': ''?>>
						<?php if($is_selected):?>
							<b><?=lang($value['name'])?></b>
						<?php elseif(!empty($value['value'])):?>
							<a href="javascript:void(0)" class="review_filter"
									data-url="<?=get_review_url($search_criteria, 'review_score_breakdown', $value['key'])?>">
								<?=lang($value['name'])?>
							</a>
						<?php else:?>
							<?=lang($value['name'])?>
						<?php endif;?>
						
						<?php if($is_selected):?>
						<span style="float: right; font-weight: bold; color: #666"><?=$value['value']?></span>
						<?php else:?>
						<span style="float: right;"><?=$value['value']?></span>
						<?php endif;?>
					</li>
					<?php $cnt++;?>
					<?php endforeach;?>
				</ul>
			</div>
			<div class="trip_type">
				<div class="bpv-color-title title"><?=lang('rev_customer_types')?></div>
				<ul>
					<?php $cnt = 0;?>
					<?php foreach ($customer_types as $value):?>
					<?php $is_selected = is_filter_selected($search_criteria, 'customer_type', $value['key']);?>
					
					<li <?=($cnt%2) == 0 ? 'class="even"': ''?>>
						<?php if($is_selected):?>
							<b><?=lang($value['name'])?></b>
						<?php elseif(!empty($value['value'])):?>
							<a href="javascript:void(0)" class="review_filter" 
									data-url="<?=get_review_url($search_criteria, 'review_customer_types', $value['key'])?>">
								<?=lang($value['name'])?>
							</a>
						<?php else:?>
							<?=lang($value['name'])?>
						<?php endif;?>
						
						<?php if($is_selected):?>
						<span style="float: right; font-weight: bold; color: #666"><?=$value['value']?></span>
						<?php else:?>
						<span style="float: right;"><?=$value['value']?></span>
						<?php endif;?>
					</li>
					<?php $cnt++;?>
					<?php endforeach;?>
				</ul>
			</div>
		</div>
	</div>
	<?php $selections = get_filter_selections($search_criteria, $score_breakdown, $customer_types)?>
	<?php if(!empty($selections)):?>
	<div class="panel_selections">
		<span class="headList"><?=lang('your_selections')?></span>
		<?=$selections?>
		<span style="color: #999; font-size: 11px;font-style: italic;"><?=lang('click_to_unselect')?></span>
	</div>
	<?php endif;?>
	<table id="comments_list">
		<?php foreach ($reviews as $review):?>
		<tr>
			<td class="cell_user">
				<div>
					<span class="icon icon-review-score">
						<span><?=$review['total_score']?></span>
					</span>
					<p style="font-size: 14px; margin-bottom: 5px"><?=$review['customer_name']?></p>
					<p style="margin-bottom: 0"><?=$review['city_name']?></p>
					<?=lang_arg('review_date', date('d', strtotime($review['review_date'])), date('m', strtotime($review['review_date'])), date('Y', strtotime($review['review_date'])) )?>
				</div>
			</td>
			<td class="cell_comments_container">
				<?php if(!empty($review['title'])):?>
				<h5><?=$review['title']?></h5>
				<?php endif;?>
				
				<?php if(!empty($review['review_content'])):?>
				<div class="review-content">
					<span id="good_<?=$review['id']?>_short">
					<?=content_shorten($review['review_content'], CUSTOMER_REVIEW_LIMIT)?>
					<?php if(fit_content_shortening($review['review_content'], CUSTOMER_REVIEW_LIMIT)):?>
						<a href="javascript:void(0)" onclick="readmore('good_<?=$review['id']?>')"><?=lang('btn_show_extra')?> &raquo;</a>
					<?php endif;?>
					</span>
					
					<?php if(fit_content_shortening($review['review_content'], CUSTOMER_REVIEW_LIMIT)):?>
							
					<span style="display: none;" id="good_<?=$review['id']?>_full">
						
						<?=str_replace("\n", "<br>", $review['review_content']);?>
						<a href="javascript:void(0)" onclick="readless('good_<?=$review['id']?>')"><?=lang('view_less')?> &laquo;</a>
					</span>
					
					<?php endif;?>
				</div>
				<div class="vote-up" id="vote_<?=$review['id']?>">
					<?php if(is_voted_review($review['id'])):?>
						<div class="bpv-color-title">
						<?=lang('voted')?> <span class="icon icon-vote-up-disable"></span>
						(<?=$review['vote_up']?>)
						</div>
					<?php else:?>
						<a href="javascript:void(0)" class="voting_btn" uniqueid="<?=$review['id']?>"> 
							<?=lang('vote_up')?> <span class="icon icon-vote-up"></span>
						</a>
						<span id="vote_count_<?=$review['id']?>">
						<?=!empty($review['vote_up']) ? ' ('.$review['vote_up'].')' : ''?>
						</span>
					<?php endif;?>
				</div>
				<?php endif;?>
			</td>
		</tr>
		<?php endforeach;?>
	</table>
	<div class="pull-right" style="margin: 10px 0">	
		<?=$paging_info['paging_links']?>
		
		<div style="float:right; padding:7px 0; margin-right:15px;">
			<?=$paging_info['paging_text']?>
		</div>
	</div>
</div>

<script>
init_review_paging();

function init_review_paging(){

	$('a.review_filter').click(function(e) {		
		e.preventDefault();
		load_reviews('#tab_reviews', $(this).attr("data-url"));
	});
	
	$(".pagination a").click(function(e) {
		e.preventDefault();				 
		load_reviews('#tab_reviews', $(this).attr("href"));
	});

	$(".voting_btn").click(function (e) {
		
	    //get unique ID from voted parent element
	    var id  = $(this).attr("uniqueid");
	   
	  	//prepare post content
        post_data = {'id':id};
       
        //send our data to server using jQuery $.post()
        $.post('/review_voting/', post_data, function(data) {

            if(data != '') {
            	 if(data == '-1') {
                	 alert("Bạn đã sử dụng chức năng này. Bạn phải đợi 24h nữa mới được thao tác tiếp");
            	 } else {
            		//replace vote up count text with new values
                     $('#vote_'+id).html('<div class="bpv-color-title"><?=lang('voted')?> <span class="icon icon-vote-up-disable"></span> ('+ data+')</div>');
            	 }
            }
        }).fail(function(err) { 
        	//alert user about the HTTP server error
       		alert("Có lỗi kết nối với server. Vui lòng thử lại sau.");
        });
	   
	});
}

function readmore(id){
	$('#'+id+'_short').hide();
	$('#'+id+'_full').show();
}

function readless(id){
	$('#'+id+'_short').show();
	$('#'+id+'_full').hide();
}
</script>
<?php endif;?>