<?php if(count($surcharges)> 0):?>
	<h2 class="bpv-color-title"><?=lang('hb_surcharge_name')?></h2>
	<?php foreach ($surcharges as $sur):?>
	<div class="bpv-panel">
		<div class="panel-heading">
		   <div class="panel-title bpv-surcharge" data-target="#surcharge_<?=$sur['id']?>">
    	        <div class="row">
        	        <div class="col-xs-10">
        	           <h3 class="bpv-color-title"><?=$sur['name']?></h3>
                    </div>
                    
                    <?php if(!empty($sur['description'])):?>
                    <div class="col-xs-2 pd-left-0 text-right">
                        <i class="bpv-toggle-icon icon icon-chevron-down"></i>
                    </div>
                    <?php endif;?>
                </div>
    	   </div>
    	   
    	   <?php if(!empty($sur['description'])):?>
    	   <div id="surcharge_<?=$sur['id']?>" class="bpv-toggle-content margin-top-10">
    	       <?=$sur['description']?>
    	   </div>
    	   <?php endif;?>
		</div>	
		
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-6">
					<?=lang('hb_surcharge_unit')?>
				</div>
				
				<div class="col-xs-6 text-right">
					
					<?php if($sur['charge_type'] != SUR_PER_ROOM_PRICE):?>
						<span class="bpv-price-from"><?=bpv_format_currency($sur['amount'])?></span><br/> /<?=get_surcharge_unit($sur)?>
					<?php else:?>
						<?=get_surcharge_unit($sur)?>
					<?php endif;?>
					
				</div>
			</div>
			<div class="sep-line"></div>
			<div class="row">
				<div class="col-xs-6">
					<?=lang('hb_surcharge_apply')?>
				</div>
				
				<div class="col-xs-6 text-right">
					<?=get_surcharge_apply($sur, $room_pax_total)?>
					
					<?php if($sur['charge_type'] == SUR_PER_ADULT_PER_BOOKING):?>
						<div class="margin-top-5">
							<a href="javascript:void(0)" data-toggle="modal" data-target="#travel_guests">(<?=lang('hb_sur_pax_change')?>)</a>
						</div>
					<?php endif;?>
				</div>
			</div>
			<div class="sep-line"></div>
			<div class="row">
				<div class="col-xs-6">
					<?=lang('hb_surcharge_total')?>
				</div>
				
				<div class="col-xs-6 text-right">
					
					<span class="bpv-price-from sur-info" id="total_charge_<?=$sur['id']?>" c-type="<?=$sur['charge_type']?>" charge="<?=$sur['amount']?>" rate="<?=$sur['total_charge']?>">
						<?=bpv_format_currency($sur['total_charge'])?>
					</span>
					
				</div>
			</div>
		
		</div>
				
	</div>
	<?php endforeach;?>
			

	
	 <?php 
      	$max_pax = $room_pax_total['max_adults'] + $room_pax_total['max_extra_beds'];
      ?>
	
	<!-- Modal -->
<div class="modal fade" id="travel_guests" tabindex="-1" role="dialog" aria-labelledby="label_travel_guests" aria-hidden="true">
  <div class="modal-dialog" style="max-width:30%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon btn-support-close"></span></button>
        <h4 class="modal-title bpv-color-title" id="label_travel_guests"><?=lang('hb_travel_guests')?></h4>
      </div>
      
      <div class="modal-body">
      	<div class="row">
      		<div class="col-xs-4">
      			<label><?=lang('hb_adult')?></label>
      			<select class="form-control" name="adults" id="adults" onchange="update_travel_guests_for_surcharge('<?=lang('vnd')?>')">
      				<?php for ($i=$room_pax_total['nr_rooms']; $i <= $max_pax; $i++):?>
      					<option value="<?=$i?>" <?=set_select('adults',$i, $i==$room_pax_total['max_adults'])?>><?=$i?></option>
      				<?php endfor;?>
      			</select>
      		</div>
      		<div class="col-xs-4">
      			<label><?=lang_arg('hb_child', $hotel['infant_age_util'] + 1, $hotel['children_age_to'])?></label>
      			<select class="form-control" name="children" id="children" onchange="update_travel_guests_for_surcharge('<?=lang('vnd')?>')">
	      			<?php for ($i=0; $i <= $max_pax; $i++):?>
	      				<option value="<?=$i?>" <?=set_select('children',$i, $i==$room_pax_total['max_children'])?>><?=$i?></option>
	      			<?php endfor;?>
      			</select>
      		</div>
      		
      		<div class="col-xs-4">
      			<label><?=lang_arg('hb_infant', $hotel['infant_age_util'])?></label>
      			<select class="form-control" name="infants" id="infants">
	      			<?php for ($i=0; $i <= $max_pax; $i++):?>
	      				<option value="<?=$i?>"><?=$i?></option>
	      			<?php endfor;?>
      			</select>
      		</div>
      	</div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-bpv" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
<?php endif;?>