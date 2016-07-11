<?php if( empty($object) || empty($reviews) ):?>
	<?=lang('empty_review')?>
<?php else:?>
<div id="review_content">
    <h4 class="text-highlight margin-top-10">
        <span><b><?=$object['review_number']?></b><?=lang('customer_review_for')?>: </span>
       	<b>
    	<?php if(!empty($page)):?>
        <a href="<?=get_page_url($page, $object)?>"><?=$object['name']?></a>
        <?php else:?>
        <?=$object['name']?>
        <?php endif;?>
       	</b>
    </h4>
    

    <div class="bpv-filter-review">
    	<div class="clearfix margin-bottom-10">
		   <div class="col-xs-6 padding-left-0">
		        <button type="button" class="btn btn-default btn-block btn-filter" data-target="#bpv-filter">
	        	    <?=lang('review_score_filter')?><span class="caret"></span>
	            </button>
		   </div>
		   <div class="col-xs-6 padding-right-0">
		        <button type="button" class="btn btn-default btn-block btn-filter" data-target="#bpv-sort">
	        	    <?=lang('review_customer_types')?><span class="caret"></span>
	        	</button>
		   </div>
		</div>
    </div>
    
    <div id="bpv-sort" class="trip-type bpv-s-content">
		<ul>
			<?php $cnt = 0;?>
			<?php foreach ($customer_types as $value):?>
			<?php $is_selected = is_filter_selected($search_criteria, 'customer_type', $value['key']);?>
			
			<li <?=empty($value['value']) ? 'class="text-unhighlight"' : ''?>>
				<?php if($is_selected):?>
					<b><?=translate_text($value['name'])?></b>
				<?php elseif(!empty($value['value'])):?>
					<a href="javascript:void(0)" class="review_filter" 
							data-url="<?=get_review_url($search_criteria, $object, 'review_customer_types', $value['key'])?>">
						<?=translate_text($value['name'])?>
					</a>
				<?php else:?>
					<?=translate_text($value['name'])?>
				<?php endif;?>
				
				<?php if($is_selected):?>
				<span class="pull-right"><b><?=$value['value']?></b></span>
				<?php else:?>
				<span class="pull-right"><?=$value['value']?></span>
				<?php endif;?>
			</li>
			<?php $cnt++;?>
			<?php endforeach;?>
		</ul>
	</div>
	
	<div id="bpv-filter" class="trip-type bpv-s-content">
		<ul>
			<?php $cnt = 0;?>
			<?php foreach ($score_breakdown as $value):?>
			<?php $is_selected = is_filter_selected($search_criteria, 'review_score', $value['key']);?>
			
			<li <?=empty($value['value']) ? 'class="text-unhighlight"' : ''?>>
				<?php if($is_selected):?>
					<b><?=translate_text($value['name'])?></b>
				<?php elseif(!empty($value['value'])):?>
					<a href="javascript:void(0)" class="review_filter" rel="nofollow"
							data-url="<?=get_review_url($search_criteria, $object, 'review_score_breakdown', $value['key'])?>">
						<?=translate_text($value['name'])?>
					</a>
				<?php else:?>
					<?=translate_text($value['name'])?>
				<?php endif;?>
				
				<?php if($is_selected):?>
				<span class="pull-right"><b><?=$value['value']?></b></span>
				<?php else:?>
				<span class="pull-right"><?=$value['value']?></span>
				<?php endif;?>
			</li>
			<?php $cnt++;?>
			<?php endforeach;?>
		</ul>
	</div>
    
    <div class="reviews-panel">
		<div id="rev_total">
			<div id="rev_total_score_number">
				<p class="review_text">
					<?=get_review_score_lang($total_score)?>
				</p>
				<div>
					<span id="rsc_total"><?=$total_score?></span>
				</div>
				<p id="rev_out_of">
					<?=lang('text_based_on').' '.$count_results.' '.lang('reviews')?>
				</p>
			</div>
		</div>
		<div class="breakdown-score-wrapper">
			<div class="trip-type trip-rating">
				<div class="text-highlight title"><?=lang('review_score_filter')?></div>
				<ul>
					<?php foreach ($score_types as $type):?>
					<li class="score-type">
						<span class="rdoSet">
							<?=translate_text($type['name'])?>
						</span>
						<div class="line">
							<div style="width:<?=($type['value']*10).'%'?>;" class="fill"></div>
						</div>
						<span class="compositeCount"><?=$type['value']?></span>
					</li>
					<?php endforeach;?>
				</ul>
			</div>
		</div>
    </div>

    <?php $selections = get_filter_selections($search_criteria, $object, $score_breakdown, $customer_types)?>
    <?php if(!empty($selections)):?>
    <div class="panel-selections">
    	<span class="head-list"><?=lang('your_selections')?></span>
    	<?=$selections?>
    	<span class="selection-note">(<?=lang('click_remore_selection')?>)</span>
    </div>
    <?php endif;?>
    
    <div class="clearfix" id="review_list">
        <?=$review_list?>
    </div>
</div>
<?php endif;?>

<script type="text/javascript">
//set box score background color
$('.reviews-panel #rev_total_score_number div').css('background', $('#rev_total_score_number .review_text label').css('color'));

$('.btn-filter').bpvToggle(function(data) {
    if( $('#bpv-sort').is(":visible") && data['id'] != '#bpv-sort') {
        $('#bpv-sort').hide();
    }
    if( $('#bpv-filter').is(":visible") && data['id'] != '#bpv-filter') {
        $('#bpv-filter').hide();
    }
});
    	
$(function() {
	// initialize review filter
	$('a.review_filter').click(function(e) {		
		e.preventDefault();
		load_bpv_reviews('#review_content', $(this).attr("data-url"));
	});
});
</script>