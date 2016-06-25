<div class="container">
    <h2 class="bpv-color-title margin-top-0"><?=lang('choose_cabin')?></h2>

    <?php foreach ($accommodations as $key => $acc):?>

    <div class="bpv-panel">
    	<div class="panel-heading">
    	   <?php if(isset($acc['cabin'])):?>
    
		      <?php $cabin = $acc['cabin'];?>
		      <div class="panel-title bpv-toggle" data-target="#acc_<?=$acc['id']?>">
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
        	   <div id="acc_<?=$acc['id']?>" class="bpv-toggle-content margin-top-10">
        	       
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
        <?php else:?>    
        
            <div class="panel-title">
    	       <h3 class="bpv-color-title"><?=$acc['name']?></h3>
    	    </div>
    	    <div id="acc_<?=$acc['id']?>" class="bpv-toggle-content margin-top-10">
    	    <?=$acc['content']?>
    	    </div>
        
        <?php endif;?>
    	</div>
    	<div class="panel-body">
    	   <div class="text-center bpv-color-promotion">
    	       <?=lang('check_rate_title')?>
    	       <i class="glyphicon glyphicon-arrow-up"></i>
    	   </div>
    	</div>
    </div>

    <?php endforeach;?>
    
    <div class="margin-top-10 margin-bottom-10 clearfix">
    	<?=load_bpv_call_us(CRUISE)?>
    </div>
</div>

<script>
$('.bpv-toggle').bpvToggle();
</script>