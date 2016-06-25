<div class="container">
    <h2 class="bpv-color-title margin-top-0"><?=lang('choose_cabin')?></h2>
    
    <?php foreach ($cruise_cabins as $key => $cabin):?>
        <?php $more_css = ($key > ($cabin_limit - 1)) ? ' more-rooms' : '';?>
    	    <?php $more_style = ($key > ($cabin_limit - 1)) ? ' style="display:none"' : '';?>
    	
            <div class="bpv-panel<?=$more_css?>"<?=$more_style?>>
            	<div class="panel-heading">
            	   <div class="panel-title bpv-toggle" data-target="#acc_<?=$cabin['id']?>">
            	        <div class="row">
                	        <div class="col-xs-10">
                	           <h3 class="bpv-color-title"><?=$cabin['name']?></h3>
                	           <span class="notes"><?=get_cruise_cabin_square_m2($cabin)?></span>
                            </div>
                            <div class="col-xs-2 pd-left-0 text-right">
                                <i class="bpv-toggle-icon icon icon-chevron-down"></i>
                            </div>
                        </div>
            	   </div>
            	   
            	   <div id="acc_<?=$cabin['id']?>" class="bpv-toggle-content margin-top-10">
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
    				   
    				   <button type="button" class="btn btn-default center-block" data-toggle="modal" data-target="#room_detail_<?=$cabin['id']?>">
    				   <?=lang('m_view_room_detail')?>
    				   </button>
            	   </div>
            	   
            	   <?=get_cabin_detail($cruise, $cabin, null, true)?>
            	</div>
            	<div class="panel-body text-center bpv-color-promotion">
            	   <?=lang('check_rate_title')?>
            	   <i class="glyphicon glyphicon-arrow-up"></i>
            	</div>
            </div>
    <?php endforeach;?>
    
    <?php if(count($cruise_cabins) > $cabin_limit):?>
    		
    	<div class="margin-bottom-10 margin-top-10 text-center">
			<a id="show_more_rooms" class="show-more-rooms" href="javascript:void(0)" show="hide" onclick="show_more_rooms()">
			<?=lang('view_more_room_types')?>
			</a>
		</div>
    
    <?php endif?>
    
    <div class="margin-top-10 margin-bottom-10 clearfix">
    	<?=load_bpv_call_us(CRUISE)?>
    </div>
</div>

<script>
$('.bpv-toggle').bpvToggle();
</script>
