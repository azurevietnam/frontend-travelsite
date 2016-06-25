<div class="bpv-collapse margin-top-2">
    <h5 class="heading no-margin" data-target="#tab_price_table">
		<i class="icon icon-star-white"></i>
		<?=lang('tab_price_table')?>
		<i class="bpv-toggle-icon icon icon-arrow-right-white pull-right"></i>
	</h5>
	<div id="tab_price_table" class="content">
	
        <h3 class="bpv-color-title no-margin"><?=lang('price_table')?></h3>
        
        <?php if(!empty($tour_rate_actions)):?>
        
        <div class="rate-tables margin-top-10">
        
            <?php foreach ($tour_rate_actions as $value):?>
            
            <?php if($value['departure_date_type'] == DEPARTURE_SPECIFIC_DATES):?>
                <?php if(!empty($value['dates'])):?>
                <?php foreach ($value['dates'] as $k => $str_date):?>

                    <div class="row">
                        <div class="col-xs-4 pd-left-0 pd-right-0"><b><?=$value['name']?></b></div>
                        <div class="col-xs-8 no-padding text-right">
                            <b><?=date(DATE_FORMAT_JS, strtotime($str_date['date']))?></b>
                        </div>
                    </div>
                    
                    <?php foreach ($accommodations as $accom):?>
                        
                        <?php if(!empty($str_date['accommodations'])):?>
    	                    <?php foreach ($str_date['accommodations'] as $acc):?>
    	                    <?php if($accom['id'] == $acc['id']):?>
    	                    <div class="row">
                                <div class="col-xs-6 pd-left-0"><?=$accom['name']?></div>
                                <div class="col-xs-6 no-padding text-right">
                                    <?php if(!empty($acc['price_from'])):?>
        	                        <div class="bpv-price-from"><?=bpv_format_currency($acc['price_from'])?></div>
        	                        <?php else:?>
        	                        <?=lang('label_updating')?>
        	                        <?php endif;?>
                                </div>
                            </div>
    	                    <?php endif;?>
    	                    <?php endforeach;?>
                        <?php else:?>
                            <div class="row">
		                 	    <div class="col-xs-6 pd-left-0"><?=$accom['name']?></div>
                        	    <div class="col-xs-6 no-padding text-right"><?=lang('label_updating')?></div>
                        	</div>
                        <?php endif;?>
                        
                    <?php endforeach;?>
                    
                    <div class="row no-border">
                        <div class="col-xs-12 text-center">
                            <button type="button" class="btn btn-bpv btn-book-now btn_book_t">
                                <span class="icon icon-btn-arrow-orange"></span><?=lang('book_tour')?>
                            </button>
                        </div>
                    </div>
                    
                
                <?php endforeach;?>
                <?php endif;?>
            <?php elseif($value['departure_date_type'] == DEPARTURE_SPECIFIC_WEEKDAYS):?>
                <?php foreach ($value['dates'] as $departure_date):?>
                    <?php if(empty($departure_date['days'])) continue;?>
                    <?php foreach ($departure_date['days'] as $k => $days):?>    
                        <?php if($k == 0):?>
                        <div class="row">
                            <div class="col-xs-12 pd-left-0">
                                <b><?=$value['name']?>
                                <?php $departure_date['week_day'] = $departure_date['weekdays'];?>
                                <?=strtolower(get_tour_departure_lang($departure_date, $week_days))?>
                                (<?=date(DATE_FORMAT_JS, strtotime($departure_date['start_date'])).' - '.date(DATE_FORMAT_JS, strtotime($departure_date['end_date']))?>)
                                </b>
                            </div>
                        </div>            
                        <?php endif;?>
                        
                        <div class="row">
                            <div class="col-xs-4 pd-left-0 pd-right-0"><b><?=$value['name']?></b></div>
                            <div class="col-xs-8 no-padding text-right">
                                <b><?=$days['date']?></b>
                            </div>
                        </div>
                        
                        <?php foreach ($accommodations as $accom):?>
                        
                        	<?php if(!empty($days['accommodations'])):?>
    		                    <?php foreach ($days['accommodations'] as $acc):?>
    		                    <?php if($accom['id'] == $acc['id']):?>
    		                    <div class="row">
                                    <div class="col-xs-6 pd-left-0"><?=$accom['name']?></div>
                                    <div class="col-xs-6 no-padding text-right">
                                        <?php if(!empty($acc['price_from'])):?>
            	                        <div class="bpv-price-from"><?=bpv_format_currency($acc['price_from'])?></div>
            	                        <?php else:?>
            	                        <?=lang('label_updating')?>
            	                        <?php endif;?>
                                    </div>
                                </div>
    		                    <?php endif;?>
    		                    <?php endforeach;?>
    		                 <?php else:?>
    		                 	<div class="row">
    		                 	    <div class="col-xs-6 pd-left-0"><?=$accom['name']?></div>
                            	    <div class="col-xs-6 no-padding text-right"><?=lang('label_updating')?></div>
                            	</div>
    		                 <?php endif;?>
    	                    
    	                <?php endforeach;?>
                        
                        <div class="row no-border">
                            <div class="col-xs-12 text-center">
                                <button type="button" class="btn btn-bpv btn-book-now btn_book_t">
                                    <span class="icon icon-btn-arrow-orange"></span><?=lang('book_tour')?>
                                </button>
                            </div>
                        </div>
                    <?php endforeach;?> 
                <?php endforeach;?>
            <?php else:?>
                <?php foreach ($value['dates'] as $departure_date):?>
                
                    <div class="row">
                        <div class="col-xs-4 pd-left-0 pd-right-0"><b><?=$value['name']?></b></div>
                        <div class="col-xs-8 no-padding text-right">
                            <?=date(DATE_FORMAT_JS, strtotime($departure_date['start_date'])).' - '.date(DATE_FORMAT_JS, strtotime($departure_date['end_date']))?>
                            (<?=strtolower(get_tour_departure_lang($departure_date, $week_days))?>)
                        </div>
                    </div>
                    
                    <?php foreach ($accommodations as $accom):?>
                        
                    	<?php if(!empty($departure_date['accommodations'])):?>
    	                    <?php foreach ($departure_date['accommodations'] as $acc):?>
    	                    <?php if($accom['id'] == $acc['id']):?>
    	                    <div class="row">
                                <div class="col-xs-6 pd-left-0"><?=$accom['name']?></div>
                                <div class="col-xs-6 no-padding text-right">
                                    <?php if(!empty($acc['price_from'])):?>
        	                        <div class="bpv-price-from"><?=bpv_format_currency($acc['price_from'])?></div>
        	                        <?php else:?>
        	                        <?=lang('label_updating')?>
        	                        <?php endif;?>
                                </div>
                            </div>
    	                    <?php endif;?>
    	                    <?php endforeach;?>
    	                 <?php else:?>
    	                 	<div class="row">
		                 	    <div class="col-xs-6 pd-left-0"><?=$accom['name']?></div>
                        	    <div class="col-xs-6 no-padding text-right"><?=lang('label_updating')?></div>
                        	</div>
    	                 <?php endif;?>
                        
                    <?php endforeach;?>
                    
                    <div class="row no-border">
                        <div class="col-xs-12 text-center">
                            <button type="button" class="btn btn-bpv btn-book-now" onclick="open_book_tab();">
                                <span class="icon icon-btn-arrow-orange"></span><?=lang('book_tour')?>
                            </button>
                        </div>
                    </div>
                <?php endforeach;?>
            <?php endif;?>
            
            <?php endforeach;?>
        </div>
        
        <?php endif;?>
        
        <div class="margin-top-10">
            <h4 class="bpv-color-title header-border"><?=lang('service_policy')?></h4>
            
            <div class="margin-top-10">
                <h5 class="bpv-color-title"><?=lang('service_inclusion')?></h5>
                <?php if(!empty($tour['service_includes'])):?>
        		
        		<?php
        			$includes = explode("\n", $tour['service_includes']);
        			$includes = array_filter($includes, 'trim');
        		?>
        		<ul style="padding-left: 15px">
        			<?php foreach ($includes as $item) :?>
        			<?php if (!empty($item)) :?>
        				<li class="margin-bottom-5"><?=$item?></li>
        			<?php endif;?>			
        			<?php endforeach;?>
        		</ul>
        		<?php endif;?>
            </div>
            
            <div class="margin-top-10">
                <h5 class="bpv-color-title"><?=lang('service_exclusion')?></h5>
                <?php if(!empty($tour['service_excludes'])):?>
        		
        		<?php
        			$excludes = explode("\n", $tour['service_excludes']);
        			$excludes = array_filter($excludes, 'trim');
        		?>
        		<ul style="padding-left: 15px">
        			<?php foreach ($excludes as $item) :?>
        			<?php if (!empty($item)) :?>
        				<li class="margin-bottom-5"><?=$item?></li>
        			<?php endif;?>			
        			<?php endforeach;?>
        		</ul>
        		<?php endif;?>
            </div>
            
            <div class="margin-top-10">
        	   <h4 class="bpv-color-title"><?=lang('children_policy_title')?></h4>
        	   <table class="table table-bordered" style="width: auto;">
        			<tr>
        				<td class="td-1"><span class="icon icon-infant margin-right-5"></span><?=str_replace('<year>', $tour['infant_age_util'], lang('infant_policy_label'))?></td>
        				<td class="td-2"><?=$tour['infants_policy']?></td>
        			</tr>
        			<tr>
        				<td>
        					<span class="icon icon-child margin-right-5"></span>
        					<?php 
        						$chd_txt = lang('children_policy_label');
        						$chd_txt = str_replace('<from>', $tour['infant_age_util'], $chd_txt);
        						$chd_txt = str_replace('<to>', $tour['children_age_to'], $chd_txt);
        					?>
        					<?=$chd_txt?>
        				</td>
        				<td><?=$tour['children_policy']?></td>
        			</tr>
        		</table>
        	</div>
            
            <?php if(!empty($default_cancellation) || !empty($tour['extra_cancellation'])):?>
            <?php 
        		$is_no_refund = $default_cancellation['id'] == CANCELLATION_NO_REFUND ? true : false;
        	?>
            <div class="margin-top-20 margin-bottom-10">
                <h5 class="bpv-color-title header-border"><?=lang('cancellation_policy')?></h5>
                <?=empty($tour['extra_cancellation']) || $is_no_refund ? $default_cancellation['content'] : $tour['extra_cancellation']?>
            </div>
            <?php endif;?>
        </div>
	
	</div>
</div>