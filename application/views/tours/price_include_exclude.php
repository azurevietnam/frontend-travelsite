<div class="clearfix"></div>
<?php if(!empty($tour['services']['includes'])):?>
<div class="price_inclusions">
	<div class="policy_header"><h3 class="highlight"><?=lang('label_price_includes')?></h3></div>
	<div class="content" style="float: left;">
		<ul>
		<?php foreach ($tour['services']['includes'] as $item) :?>
		<?php if ($item != '') :?>
			<li><?=$item?></li>
		<?php endif;?>			
		<?php endforeach;?>
		</ul>
	</div>			
</div>
<?php endif;?>

<?php if(!empty($tour['services']['excludes'])):?>
<div class="price_exclusions">
	<div class="policy_header"><h3 class="highlight"><?=lang('label_price_excludes')?></h3></div>
	<div class="content" style="float: left;">
		<ul>
			<?php foreach ($tour['services']['excludes'] as $item) :?>
			<?php if ($item != '') :?>
				<li><?=$item?></li>
			<?php endif;?>
			<?php endforeach;?>
		</ul>
	</div>
</div>	
<?php endif;?>

<div class="booking_policy">
	<div class="policy_header">
		<h3 class="highlight">
			
			<?php 
				$has_recommendation = isset($recommendations) && count($recommendations) > 0;
			?>
			
			<?php if($has_recommendation):?>
			
			<img id="img_booking_policy_<?=$tour['id']?>" onclick="show_policy()" src="<?=site_url('media').'/btn_mini.gif'?>" style="cursor: pointer; margin-bottom: -1px;">
			
			<a href="javascript:show_policy()" class="highlight"><?=lang('label_booking_policy')?></a>
			
			
			<a href="javascript:show_policy()" style="font-weight:normal;font-size:11px;" id="info_booking_policy_<?=$tour['id']?>">(<?=lang('label_click_to_see')?>)</a>
			
			<?php else:?>
				<?=lang('label_booking_policy')?>
			<?php endif;?>
	
		</h3>
	</div>
	<div id="booking_policy_<?=$tour['id']?>" <?php if($has_recommendation):?>style="display: none;"<?php endif;?>>
	
		<div class="col_1"><?=lang('lb_cancellation_by_customer')?>:</div>
		<?php if(!empty($tour['policies']['cancellation'])):?>
		<div class="col_2">
			<ul style="list-style: none;padding-left:0">
			<?php foreach ($tour['policies']['cancellation'] as $item) :?>
			<?php if ($item != '') :?>
				<li><?=$item?></li>
			<?php endif;?>
			<?php endforeach;?>
			</ul>	
			
		</div>
		<?php endif;?>
		
		<?php if($cancellation_weather != ''):?>
			<div class="clearfix"></div>
			<div class="col_1"><?=lang('text_cancellation_policy_bad_eather')?>:</div>
			<div class="col_2">
				
				<?=$cancellation_weather?>
			</div>
		
		<?php endif;?>
		
		<div class="clearfix"></div>
		<div class="col_1"><?=lang('lb_children_price_extra_bed')?>:</div>
		<div class="col_2">
			<?php if(!empty($tour['policies']['children_extrabed'])):?>
			<ul style="list-style: none;padding-left:0">
			<?php foreach ($tour['policies']['children_extrabed'] as $item) :?>
			<?php if ($item != '') :?>
				<li><?=$item?></li>
			<?php endif;?>	
			<?php endforeach;?>
			</ul>		
			<?php endif;?>	
		</div>
	
	</div>
	
</div>

<script type="text/javascript">

function show_policy(){

	var img_id = "#img_booking_policy_<?=$tour['id']?>";
	
	var src = $(img_id).attr("src"); 

	if (src == "<?=site_url('media').'/btn_mini.gif'?>"){
		
		src = "<?=site_url('media').'/btn_mini_hover.gif'?>";

		$(img_id).attr("src", src);

		$("div#booking_policy_<?=$tour['id']?>").show();

		$("#info_booking_policy_<?=$tour['id']?>").text('(click to hide)');
		
	} else {

		src = "<?=site_url('media').'/btn_mini.gif'?>";

		$(img_id).attr("src", src);

		$("div#booking_policy_<?=$tour['id']?>").hide();

		$("#info_booking_policy_<?=$tour['id']?>").text('(<?=lang('label_click_to_see')?>)');

	}
	
}

</script>
