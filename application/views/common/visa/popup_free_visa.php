<a class="text-special free-visa-popup" data-target="#free_visa_cnt" data-placement="right" data-title="<?=lang('free_vietnam_visa')?>"
			href="javascript:void(0)">

<?php if($show_icon_deal):?>
	<span class="icon icon-deal-offer-green"></span>
<?php endif;?>

<?=lang('free_vietnam_visa')?> &raquo;

</a>
			
<div style="display:none" id="free_visa_cnt">
	<?=$free_visa_content?>
</div>

<script type="text/javascript">
	set_popover('.free-visa-popup');
</script>