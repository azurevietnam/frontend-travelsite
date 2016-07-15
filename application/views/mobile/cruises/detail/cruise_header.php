<div class="clearfix cruise-ids margin-bottom-10" data-id="<?=$cruise['id']?>">
    <?=ucfirst(lang('label_from'))?>:
    <span class="price-origin c-origin-<?=$cruise['id']?>"></span>
    <span class="price-from c-from-<?=$cruise['id']?>" style="display:none"><?=lang('na')?></span>
    <?=lang('per_pax')?>
</div>

<i><?=$cruise['address']?></i>

<?php if(!empty($cruise['description'])):?>
    <?php $descriptions = str_replace("\n", "<br>", strip_tags($cruise['description']))?>
    <div class="margin-top-10 col-desc clearfix pull-left">
        <span id="short_desc">
            <?=content_shorten($descriptions, MOBILE_CRUISE_SHORT_DESCRIPTION_LENGTH)?>
            <?php if(fit_content_shortening($descriptions, MOBILE_CRUISE_SHORT_DESCRIPTION_LENGTH)):?>
            <a href="javascript:void(0)" class="btn-more"><?=strtolower(lang('lb_more'))?> &raquo;</a>
            <?php endif;?>
        </span>
        <?php if(fit_content_shortening($descriptions, MOBILE_CRUISE_SHORT_DESCRIPTION_LENGTH)):?>
			<span id="full_desc">
			<?=$descriptions?>
			<a href="javascript:void(0)" class="btn-more"><?=strtolower(lang('lb_less'))?> &laquo;</a>
			</span>
		<?php endif;?>
    </div>
<?php endif;?>

<script>
//toggle description
$('.btn-more').click(function() {
	if( $('#short_desc').is(":visible")) {
        $('#short_desc').hide();
        $('#full_desc').show();
    } else {
    	$('#short_desc').show();
        $('#full_desc').hide();
    }
});
</script>