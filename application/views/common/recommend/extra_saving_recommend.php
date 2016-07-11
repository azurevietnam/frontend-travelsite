<?php if(count($recommendations) > 0):?>
<div class="margin-bottom-15" style="font-size:14px;margin-top:-5px">
	<span class="icon icon-deals"></span>
	<span class="text-highlight"><strong><?=lang('extra_saving')?>:</strong></span>
	<span><?=get_recommendation_text($recommendations)?>&nbsp;</span>
	<a href="javascript:void(0)" style="text-decoration:underline;" onclick="go_position('#booking_together_section')"><?=lang('see_deals')?> &raquo;</a>		
</div>
<?php endif;?>