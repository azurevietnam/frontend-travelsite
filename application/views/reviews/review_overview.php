<?php if(!empty($number_of_reviews)):?>
<?php if(empty($rich_snippet)):?>
<div class="col-review">
    <span class="icon icon-review"></span>
    <ul>
        <li>
            <span class="review-lang"><?=get_review_score_lang($review_score)?></span> - 
            <span class="text-highlight"><span class="review-score"><?=$review_score?></span>/10</span>
        </li>
        <li>
            <a class="review_link" href="<?=!empty($review_link) ? $review_link : 'javascript:void()'?>"><?=lang_arg('lbl_number_of_reviews', $number_of_reviews)?></a>
        </li>
    </ul>
</div>
<?php else:?>
<div class="col-review">
    <meta property="v:itemreviewed" content="<?=$rich_snippet['name']?>"/>
    <meta rel="v:photo" content="<?=$rich_snippet['photo']?>"/>
    
    <span class="icon icon-review"></span>
    <ul class="pull-left">
        <li>
            <span class="review-lang"><?=get_review_score_lang($review_score)?></span> - 
            <span rel="v:rating">
                <span typeof="v:Rating">
                    <span class="text-highlight"><span class="review-score"><span property="v:average"><?=$review_score?></span></span>/10</span>
                    <meta property="v:best" content="10" />
                </span>
		   	</span>
        </li>
        <li>
            <a class="review_link" href="<?=!empty($review_link) ? $review_link : 'javascript:void()'?>"><?=lang_arg('lbl_number_of_reviews', '<span property="v:count">'.$number_of_reviews.'</span>')?></a>
        </li>
    </ul>
</div>
<?php endif;?>
<?php endif;?>