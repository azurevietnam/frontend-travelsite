	<?php if ($is_show_background):?>
	
		<div class="item-offer">
	
	<?php endif;?>

			<ul class="list-unstyled">
			  <?php foreach ($promotions as $key => $pro):?>
			  		
			  		
			  		<?php if($show_pro_detail):?>
			  		
			  			<?php 
			  				$offers = $pro['offer_note'];
			  				if(!empty($offers)){
								$offers = explode("\n", $offers);
							}
			  			?>
			  			
			  			<?php foreach ($offers as $offer):?>
			  				
			  				<?php if(!empty($offer)):?>
			  					<li>					
									<a class="text-special pro-offer-note" data-placement="auto" data-target="#pro_cnt_<?=$pro['id']?>" data-title="<?=$pro['name']?>"
										href="javascript:void(0)"><?=$offer?></a>
								</li>
					
			  				<?php endif;?>
			  				
			  			<?php endforeach;?>
					
					<?php else:?>
								  
					<li>					
						<a class="text-special pro-offer-note" data-placement="auto" data-target="#pro_cnt_<?=$pro['id']?>" data-title="<?=$pro['name']?>"
							href="javascript:void(0)"><?=$pro['name']?></a>
					</li>
					
					<?php endif;?>
					
			  <?php endforeach;?>
			</ul>
			
			<?php if ($is_show_background):?>
				<span class="item-offer-arrow-before"></span>
				<span class="item-offer-arrow-after"></span>
				<span class="item-arrow-circle"></span>
			<?php endif;?>
			
	<?php if ($is_show_background):?>		
		</div>
	<?php endif;?>


	<?php foreach ($promotions as $k=>$value):?>
		<div id="pro_cnt_<?=$value['id']?>" style="display: none">
			<?=$value['pro_content']?>
		</div>
	<?php endforeach;?>

<script type="text/javascript">
	set_popover('.pro-offer-note');
</script>