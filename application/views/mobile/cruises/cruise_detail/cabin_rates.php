<div class="container">
<form id="room-rates" role="form" method="post" action="<?=tour_booking_url($tour, $check_rate_info)?>">
    <input type="hidden" name="action" value="<?=ACTION_BOOK_NOW?>">
	
	<h2 class="bpv-color-title margin-top-0"><?=lang('choose_cabin')?></h2>
	
	<?php foreach ($accommodations as $key => $acc):?>
	    <?php $more_css = ($key > ($cabin_limit - 1)) ? ' more-rooms' : '';?>
	    <?php $more_style = ($key > ($cabin_limit - 1)) ? ' style="display:none"' : '';?>
	
      <div class="bpv-panel<?=$more_css?>"<?=$more_style?>>
        	<div class="panel-heading">
        	   
    	       <?php if(isset($acc['cabin'])):?>
    	           <?php $cabin = $acc['cabin'];?>
    	           <?php
    	               $cabin_detail_id = 'acc_'.$acc['id'];
        	           if(isset($acc['promotion'])) {
        	               $cabin_detail_id .= '_'.$acc['promotion']['id'];
        	           } 
    	           ?>
    	           <div class="panel-title bpv-toggle" data-target="<?='#'.$cabin_detail_id?>">
            	        <div class="row">
                	        <div class="col-xs-10">
                	           <h3 class="bpv-color-title"><?=$cabin['name']?></h3>
                	           <span class="notes">
                	               <?=get_cruise_cabin_square_m2($cabin)?>
                	               <?php $is_no_cancell = $acc['cancellation']['id'] == CANCELLATION_NO_REFUND; ?>
                	               <?php if($is_no_cancell):?>
                	               <br><span class="bpv-color-warning"><?=lang('no_cancel')?></span>
                	               <?php endif;?>
                	           </span>
                	           
                            </div>
                            <div class="col-xs-2 pd-left-0 text-right">
                                <i class="bpv-toggle-icon icon icon-chevron-down"></i>
                            </div>
                        </div>
            	   </div>
            	   
            	   <div id="<?=$cabin_detail_id?>" class="bpv-toggle-content margin-top-10">
            	       
            	        <?php if(!empty($cabin['picture'])):?>
    			        <img class="img-responsive" src="<?=get_image_path(CRUISE, $cabin['picture'],'416x312')?>" alt="<?=$cabin['name']?>">
    				    <?php endif;?>
      			
              			<p class="bpv-color-green margin-bottom-10 margin-top-10">
        					<b>* <?=get_cruise_breakfast_vat_txt($cabin)?></b>
        				</p>
    		
            		    <?php if($cabin['max_children'] > 0):?>
            			<p>
            				 * <?=lang_arg('room_children_allow', $cabin['max_children'])?>
            			</p>
            		    <?php endif;?>
            		
            		    <?php if($cabin['max_extra_beds'] > 0):?>
            			<p>
            				 * <?=lang_arg('room_extra_bed_allow', $cabin['max_extra_beds'])?>
            			</p>
            		    <?php endif;?>
            		
                		<p><?=$cabin['description']?></p>
                		
                		<?php 
							$cabin_detail_id = '#room_detail_'.$cabin['id'];
							if(isset($acc['promotion'])) {
								$cabin_detail_id .= '_'.$acc['promotion']['id'];
							}
						?>
    				   
    				    <button type="button" class="btn btn-default center-block" data-toggle="modal" data-target="<?=$cabin_detail_id?>">
    				    <?=lang('m_view_room_detail')?>
    				    </button>
            	   </div>
            	   
            	   <?=get_cabin_detail($cruise, $cabin, $acc, true)?>
        	   
        	   <?php else:?>
        	   
            	   <div class="panel-title">
            	       <h3 class="bpv-color-title"><?=$acc['name']?></h3>
            	   </div>
            	   
            	   <div id="acc_<?=$acc['id']?>" class="bpv-toggle-content margin-top-10">
            	   <?=$acc['content']?>
            	   </div>
            	   
        	   <?php endif;?>
        	   
        	</div>
        	<div class="panel-body rate-tables">
        	
        	   <?php if(!empty($acc['sell_rate'])):?>
        	   
        	       <?php if(isset($acc['promotion']) && $acc['promotion']['show_on_web']):?>
				   <div class="row">
						<?=load_promotion_tooltip($acc['promotion'], $acc['id'].'_acc', '', true)?>
				   </div>
				   <?php endif;?>
        	
            	   <div class="row">
                        <div class="col-xs-6 pd-left-0"><?='1 '.lang('adult_label')?></div>
    					<div class="col-xs-6 pd-right-0 text-right bpv-price-from"><?=bpv_format_currency($acc['adult_rate'])?></div>
            	   </div>
            	   
            	   <?php if(!empty($check_rate_info['children'])):?>
            	   <div class="row">
        	           <div class="col-xs-6 pd-left-0"><?='1 '.lang('children_label')?></div>
        	           
        	           <div class="col-xs-6 pd-right-0 text-right">
        					<?php if(!empty($acc['children_rate'])):?>
        					    <div class="bpv-price-from">
        						<?=bpv_format_currency($acc['children_rate'])?>
        						</div>
        					<?php else:?>
        						<div class="bpv-color-price"><?=lang('free_of_charge')?></div>
        					<?php endif;?>
    				    </div>
    			   </div>
        	       <?php endif;?>
        	       
        	       <?php if(!empty($check_rate_info['infants'])):?>
        	       <div class="row">
        	           <div class="col-xs-6 pd-left-0"><?='1 '.lang('infant_label')?></div>
        	           
        	           <div class="col-xs-6 pd-right-0 text-right">
        					<?php if(!empty($acc['infant_rate'])):?>
        					    <div class="bpv-price-from">
        						<?=bpv_format_currency($acc['infant_rate'])?>
        						</div>
        					<?php else:?>
        						<div class="bpv-color-price"><?=lang('free_of_charge')?></div>
        					<?php endif;?>
    				    </div>
        	       </div>
        	       <?php endif;?>
        	       
        	       <?php if($check_rate_info['adults']%2 != 0):?>
        	       <div class="row">
        	           <div class="col-xs-6 pd-left-0"><?='1 '.lang('single_sup')?></div>
        	           
        	           <div class="col-xs-6 pd-right-0 text-right bpv-price-from">
        					<?=bpv_format_currency($acc['single_sup_rate'])?>
    				    </div>
        	       </div>
        	       <?php endif;?>
        	       
        	       <?php if(!empty($acc['sell_rate'])):?>
        	       <div class="row no-border">
        	           <div class="col-xs-6 pd-left-0"><b><?=lang('total_price')?></b></div>
        	           
        	           <div class="col-xs-6 pd-right-0 text-right bpv-price-total">
        					<?=bpv_format_currency($acc['sell_rate'])?>
    				    </div>
        	       </div>
        	       <?php endif;?>
        	       
        	       <div class="row no-border">
            	       <div class="col-xs-6 col-xs-offset-6 no-padding">
            	       <button class="btn btn-bpv btn-book-now btn-block" type="submit" name="selected_cabin" value="<?=get_tour_rate_id($acc)?>"><?=lang('btn_book_now')?></button>
            	       </div>
        	       </div>
        	       
        	   <?php else:?>
        	   
                    <?php $params = get_contact_params($tour, $check_rate_info);?>
                    <a type="button" class="btn btn-bpv btn-book-now btn-sm" href="<?=get_url(CONTACT_US_PAGE, $params)?>">
                    	<?=lang('contact_for_price')?>
                    </a>
        	   
        	   <?php endif;?>
        	</div>
        </div>
	
	<?php endforeach;?>	
	
	<?php if(count($accommodations) > $cabin_limit):?>
		
		<div class="margin-bottom-10 margin-top-10 text-center">
			<a id="show_more_rooms" class="show-more-rooms" href="javascript:void(0)" show="hide" onclick="show_more_rooms()">
			<?=lang('view_more_room_types')?>
			</a>
		</div>
	
	<?php endif?>
</form>

<div class="margin-top-10 margin-bottom-10 clearfix">
	<?=load_bpv_call_us(CRUISE)?>
</div>

</div>

<?=$price_include_exclude?>

<script>
$('.bpv-toggle').bpvToggle();
</script>