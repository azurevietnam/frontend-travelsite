<a href="javascript:void(0)" class="bpv-color-promotion pop-promotion" id="pro_detail_<?=$pro['id'].'_'.$obj_id?>">
	<span class="icon icon-promotion" style="margin:2px 5px 0 0"></span>
	<?=$pro['name']?>
</a>

<div id="pro_title_<?=$pro['id'].'_'.$obj_id?>" style="display: none">
	<b><?=$pro['name']?></b>
	<span onclick="$('#pro_detail_<?=$pro['id'].'_'.$obj_id?>').popover('hide');" class="icon btn-support-close"></span>
</div>

<div id="pro_content_<?=$pro['id'].'_'.$obj_id?>" style="display: none;">
	
	<div class="margin-bottom-10">
		<?=lang_arg('hp_valid_to', date(DATE_FORMAT, strtotime($pro['book_date_from'])), date(DATE_FORMAT, strtotime($pro['book_date_to'])))?>
	</div>
	
	<div style="min-width:280px;" class="margin-bottom-10">
		<?=lang_arg('hp_stay_date', date(DATE_FORMAT, strtotime($pro['stay_date_from'])), date(DATE_FORMAT, strtotime($pro['stay_date_to'])))?>
	</div>
	
	<?php 
		$cnt = 0;
		foreach ($week_days as $key=>$value){
			if(is_bit_value_contain($pro['check_in_on'], $key)){
				$cnt++;
			}
		}
		
	?>
	
	<?php if($cnt <7):?>
	<div class="margin-bottom-10">
		<b><?=lang('hp_apply_on')?>:</b>
		<?php foreach ($week_days as $key=>$value):?>
			
			<?php if(is_bit_value_contain($pro['check_in_on'], $key)):?>
				<?=lang($value)?>, 
			<?php endif;?>
			
		<?php endforeach;?>
	</div>
	<?php endif;?>
	
	<?php if($pro['offer'] != ''):?>
		<div class="margin-bottom-10">
			<?=$pro['offer']?>
		</div>
	<?php endif;?>
	
</div>

<script type="text/javascript">
	$('#pro_detail_<?=$pro['id'].'_'.$obj_id?>').popover(
			{'html':true,
			'trigger':'click',
			template: '<div class="popover popover-pro"><div class="arrow"></div><div class="popover-inner"><h3 class="popover-title"></h3><div class="popover-content"></div></div></div>',
			'title':$('#pro_title_<?=$pro['id'].'_'.$obj_id?>').html(), 
			'content':$('#pro_content_<?=$pro['id'].'_'.$obj_id?>').html(),
			'placement':'<?=$position?>'}
	);

	/*$('.pop-promotion').on('click', function (e) {
	    $('.pop-promotion').not(this).popover('hide');
	});*/
</script>
										
