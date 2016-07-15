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
			  					<li style="margin-bottom: 5px;">					
									<a class="text-special" data-toggle="modal" data-target="#pro_cnt_<?=$pro['id']?>"
										href="javascript:void(0)"><span class="icon icon-promotion"></span><?=$offer?> &raquo;</a> 
								</li>
					
			  				<?php endif;?>
			  				<!-- glyphicon glyphicon-chevron-right icon icon-arrow-right-gray-->
			  			<?php endforeach;?>
					
					<?php else:?>
								  
					<li style="margin-bottom: 5px;">
							<a class="text-special pro-offer-note" data-toggle="modal" data-target="#pro_cnt_<?=$pro['id']?>"
										href="javascript:void(0)"><span class="icon icon-promotion"></span><?=$pro['name']?> <i class="icon icon-arrow-right-gray"></i></a>
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
	
		<!-- Modal -->
		<div class="modal fade" id="pro_cnt_<?=$value['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close glyphicon glyphicon-remove" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
		        <h3 class="modal-title text-special" id="myModalLabel"><?=$value['name']?></h3>
		      </div>
		      <div class="modal-body">
		      		<?=$value['pro_content']?>
		      </div>
		      <div class="modal-footer">
		      	<div class="row">
		      		<div class="col-xs-10 col-xs-offset-1">
		      			<button type="button" class="btn btn-blue btn-block" data-dismiss="modal"><?=lang('lbl_close')?></button>
		      		</div>
		      	</div>
		      </div>
		    </div>
		  </div>
		</div>
	<?php endforeach;?>