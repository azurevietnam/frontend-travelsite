<table id="comments_list">
	<?php foreach ($reviews as $key => $review):?>
	<tr>
		<td class="cell-user">
			<div>
				<span class="icon icon-review-score">
					<span><?=$review['total_score']?></span>
				</span>
				<p class="margin-bottom-5"><b><?=$review['guest_name']?></b></p>
				<p class="margin-bottom-0"><?=!empty($review['guest_city']) ? $review['guest_city'].',' : ''?> <?=$customer_countries[$review['guest_country']][0]?></p>
				<span class="text-highlight review-date"><?=date('j F, Y', strtotime($review['review_date']))?></span>
			</div>
		</td>
		<td>
			
			<p class="comments_good">
				<?php $good_comment = format_review_text($review['positive_review'])?>
				<span class="icon icon-positive-review"></span>
				<span id="good_<?=$key?>_short">
					<?=content_shorten($good_comment, CUSTOMER_REVIEW_LIMIT)?>

					<?php if(fit_content_shortening($good_comment, CUSTOMER_REVIEW_LIMIT)):?>
						<a href="javascript:void(0)" onclick="read_more('good_<?=$key?>')"><?=ucfirst(lang('lb_more'))?></a>
					<?php endif;?>
				</span>

				<?php if(fit_content_shortening($good_comment, CUSTOMER_REVIEW_LIMIT)):?>
				<span style="display: none;" id="good_<?=$key?>_full">
					<?=$good_comment?>
					<a href="javascript:void(0)" onclick="read_less('good_<?=$key?>')"><?=ucfirst(lang('lb_less'))?></a>
				</span>
				<?php endif;?>
			</p>
			
			<?php if(!empty($review['negative_review'])):?>
			<p class="comments_bad">
				<?php $bad_comment = format_review_text($review['negative_review'])?>
				<span class="icon icon-negative-review"></span>
				<span id="bad_<?=$key?>_short">
					<?=content_shorten($bad_comment, CUSTOMER_REVIEW_LIMIT)?>

					<?php if(fit_content_shortening($bad_comment, CUSTOMER_REVIEW_LIMIT)):?>
						<a href="javascript:void(0)" onclick="read_more('bad_<?=$key?>')"><?=ucfirst(lang('lb_more'))?></a>
					<?php endif;?>
				</span>

				<?php if(fit_content_shortening($bad_comment, CUSTOMER_REVIEW_LIMIT)):?>
				<span style="display: none;" id="bad_<?=$key?>_full">
					<?=$bad_comment?>
					<a href="javascript:void(0)" onclick="read_less('bad_<?=$key?>')"><?=ucfirst(lang('lb_less'))?></a>
				</span>
				<?php endif;?>
			</p>
			<?php endif;?>
			
		</td>
	</tr>
	<?php endforeach;?>
</table>
<div class="review-paging">	
    <div class="pull-left">
		<?=$paging_info['paging_text']?>
	</div>
	<div class="pull-right pagination">
		<?=$paging_info['paging_links']?>
	</div>
</div>

<script>
$(function() {
	// initialize review paging
	$(".pagination a").click(function(e) {
		e.preventDefault();				 
		load_bpv_reviews('#review_list', $(this).attr("href"));
	});
});
</script>