<!-- Modal -->
<div class="modal fade" id="sur_detail_<?=$sur['id']?>" tabindex="-1" role="dialog" aria-labelledby="sur_label_<?=$sur['id']?>" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon btn-support-close"></span></button>
        <h4 class="bpv-color-title modal-title" id="sur_label_<?=$sur['id']?>"><?=$sur['name']?></h4>
      </div>
      <div class="modal-body">
      	
      	<div class="form-group row">
			<div class="col-xs-3"><?=lang('rate_field_surcharge_name')?>:</div>
			<div class="col-xs-9"><b><?=$sur['name']?></b></div>
		</div>
		
		<div class="form-group row">
			<div class="col-xs-3"><?=lang('rate_surcharge_date_apply')?>:</div>
			<div class="col-xs-9"><?=lang('from')?> <b><?=date(DATE_FORMAT, strtotime($sur['start_date']))?></b> <?=lang('to')?> <b><?=date(DATE_FORMAT, strtotime($sur['end_date']))?></b></div>
		</div>
		
		<div class="form-group row">
			<div class="col-xs-3"><?=lang('rate_surcharge_week_day_apply')?>:</div>
			<div class="col-xs-9">
				<?php foreach ($week_days as $k=>$wd):?>
			    	<label class="checkbox-inline">    		
			  			<input type="checkbox" value="<?=$k?>" <?=set_checkbox('week_day[]',$k, is_bit_value_contain($sur['week_day'], $k))?> name="week_day[]" > <?=lang($wd)?>
					</label>
				<?php endforeach;?>	
			</div>
		</div>
		
		<div class="form-group row">
			<div class="col-xs-3"><?=lang('sur_field_charge_type')?>:</div>
			<div class="col-xs-9"><?=$charge_types[$sur['charge_type']]?></div>
		</div>
		
		<div class="form-group row">
			<div class="col-xs-3"><?=lang('sur_field_amount')?>:</div>
			<div class="col-xs-9"><b><?=number_format($sur['amount'])?></b> <?=lang('vnd')?></div>
		</div>
		
		<?php if(!empty($sur['description'])):?>
		
		<div class="form-group row">
			<div class="col-xs-3"><?=lang('sur_field_description')?>:</div>
			<div class="col-xs-9"><?=$sur['description']?></div>
		</div>
		
		<?php endif;?>
      	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-bpv" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>