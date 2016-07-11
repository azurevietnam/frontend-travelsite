<div class="modal fade" id="acc_info_<?=$acc['id']?>" tabindex="-1" role="dialog" aria-labelledby="<?=$acc['name']?>" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span></button>
        <h2 class="text-highlight modal-title" id=acc_label_<?=$acc['id']?>>
        	<?=$acc['name']?>
        </h2>
      </div>
      <div class="modal-body">
      	
      	<?php if(!is_cruise_cabin($acc)):?>
      	
      		<?=insert_see_overview_link(generate_string_to_list($acc['content']))?>
      		
      	<?php else:?>
      	
          	<div class="clearfix">
                <div>
        			<label class="text-unhighlight"><?=lang('lbl_cabin_size')?>:</label> <?=lang('lbl_m2', $acc['cabin_size'])?>
        		</div>
        		<div>
        			<label class="text-unhighlight"><?=lang('lbl_bed_size')?>:</label> <?=$acc['bed_size']?>
        		</div>
        		
        		<div>
        			<label class="text-unhighlight"><?=lang('lbl_max_person')?>:</label> <?=$acc['max_person']?>
        		</div>
        		
        		<?php if(!empty($acc['cabin_facilities'])):?>
        		
        			<h4 class="text-highlight margin-top-5"><b><?=lang('lbl_cabin_facilities')?></b></h4>
        			
        			<ul class="bpt-list-checked list-unstyled">
        				<?php foreach ($acc['cabin_facilities'] as $value):?>
        					<li class="col-xs-6 padding-left-0 margin-bottom-5">
        					<?php if($value['important'] == STATUS_ACTIVE):?>
        						<b><?=$value['name']?></b>
        					<?php else:?>
        						<?=$value['name']?>
        					<?php endif;?>
        					</li>
        				<?php endforeach;?>
        			</ul>
        		<?php endif;?>
          	</div>
        
      	<?php endif;?>
      	
      </div>
      <div class="modal-footer modal-background-footer text-center">
        <div class="col-xs-8 col-xs-offset-2">
            <button type="button" class="btn btn-blue btn-block" data-dismiss="modal"><?=lang('lbl_close')?></button>
        </div>
      </div>
    </div>
  </div>
</div>