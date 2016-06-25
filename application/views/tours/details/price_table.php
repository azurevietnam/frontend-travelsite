<h3 class="bpv-color-title no-margin"><span class="icon icon-price-details"></span><?=lang('price_table')?></h3>
<?php if(!empty($tour_rate_actions)):?>

<table class="table table-bordered table-price margin-top-10">
    <thead>
        <tr>
            <th><?=lang('departing_from')?></th>
            <th class="text-center"><?=lang('departure_date')?></th>
            <?php foreach ($accommodations as $accom):?>
            <th class="text-center"><?=$accom['name']?></th>
            <?php endforeach;?>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tour_rate_actions as $value):?>
        
        <?php if($value['departure_date_type'] == DEPARTURE_SPECIFIC_DATES):?>
            <?php if(!empty($value['dates'])):?>
            <?php foreach ($value['dates'] as $k => $str_date):?>
            <tr>
                <?php if($k == 0):?>
                <td rowspan="<?=count($value['dates'])?>">
                    <?=$value['name']?>
                </td>
                <?php endif;?>
    
                <td align="center"><?=date(DATE_FORMAT_JS, strtotime($str_date['date']))?></td>
                
                <?php 
                    $contact_params = array(
                        'startdate' => date(DATE_FORMAT_JS, strtotime($str_date['date']))
                    );
                    $params = get_tour_contact_params($tour, $contact_params);
                ?>
                
                <?php foreach ($accommodations as $accom):?>
                    
                    <?php if(!empty($str_date['accommodations'])):?>
	                    <?php foreach ($str_date['accommodations'] as $acc):?>
	                    <?php if($accom['id'] == $acc['id']):?>
	                    <td align="center">
	                        <?php if(!empty($acc['price_from'])):?>
	                        <div class="bpv-price-from"><?=bpv_format_currency($acc['price_from'])?></div>
	                        <?php else:?>
	                        <a href="<?=get_url(CONTACT_US_PAGE, $params)?>"><?=lang('contact_for_price')?></a>
	                        <?php endif;?>
	                    </td>
	                    <?php endif;?>
	                    <?php endforeach;?>
                    <?php else:?>
                    	<td align="center"><a href="<?=get_url(CONTACT_US_PAGE, $params)?>"><?=lang('contact_for_price')?></a></td>
                    <?php endif;?>
                    
                <?php endforeach;?>
                
                <?php if($k == 0):?>
                <td align="center" rowspan="<?=count($value['dates'])?>">
                    <button type="button" class="btn btn-bpv btn-book-now btn_book_t">
                    <span class="icon icon-btn-arrow-orange"></span>
                    <?=lang('book_tour')?>
                    </button>
                </td>
                <?php endif;?>
                
            </tr>
            <?php endforeach;?>
            <?php endif;?>
        <?php elseif($value['departure_date_type'] == DEPARTURE_SPECIFIC_WEEKDAYS):?>
            <?php foreach ($value['dates'] as $departure_date):?>
                <?php if(empty($departure_date['days'])) continue;?>
                <?php foreach ($departure_date['days'] as $k => $days):?>    
                <tr>
                    <?php if($k == 0):?>
                    <td width="25%" rowspan="<?=count($departure_date['days'])?>">
                        <?=$value['name']?>
                        <br>
                        <?php $departure_date['week_day'] = $departure_date['weekdays'];?>
                        <?=strtolower(get_tour_departure_lang($departure_date, $week_days))?>
                        <br>
                        (<?=date(DATE_FORMAT_JS, strtotime($departure_date['start_date'])).' - '.date(DATE_FORMAT_JS, strtotime($departure_date['end_date']))?>)
                    </td>            
                    <?php endif;?>
                    
                    <td align="center"><?=$days['date']?></td>
                    
                    <?php 
                        $contact_params = array(
                            'startdate' => $days['date']
                        );
                        $params = get_tour_contact_params($tour, $contact_params);
                    ?>
                    
                    <?php foreach ($accommodations as $accom):?>
                    
                    	<?php if(!empty($days['accommodations'])):?>
		                    <?php foreach ($days['accommodations'] as $acc):?>
		                    <?php if($accom['id'] == $acc['id']):?>
		                    <td align="center">
		                        <?php if(!empty($acc['price_from'])):?>
		                        <div class="bpv-price-from"><?=bpv_format_currency($acc['price_from'])?></div>
		                        <?php else:?>
		                        <a href="<?=get_url(CONTACT_US_PAGE, $params)?>"><?=lang('contact_for_price')?></a>
		                        <?php endif;?>
		                    </td>
		                    <?php endif;?>
		                    <?php endforeach;?>
		                 <?php else:?>
		                 	<td align="center"><a href="<?=get_url(CONTACT_US_PAGE, $params)?>"><?=lang('contact_for_price')?></a></td>
		                 <?php endif;?>
	                    
	                <?php endforeach;?>
                    
                    <?php if($k == 0):?>
                    <td align="center" rowspan="<?=count($departure_date['days'])?>">
                        <button type="button" class="btn btn-bpv btn-book-now btn_book_t">
                        <span class="icon icon-btn-arrow-orange"></span>
                        <?=lang('book_tour')?>
                        </button>
                    </td>
                    <?php endif;?>
                </tr>   
                <?php endforeach;?> 
            <?php endforeach;?>
            
        <?php elseif($value['departure_date_type'] == DEPARTURE_DAILY):?>
            
            <?php if(!empty($value['dates'])):?>
            <?php foreach ($value['dates'] as $departure_date):?>
            <tr>
                <td>
                    <?=$value['name']?>
                </td>
                
                <td align="center">
                    <?=date(DATE_FORMAT_JS, strtotime($departure_date['start_date'])).' - '.date(DATE_FORMAT_JS, strtotime($departure_date['end_date']))?>
                    (<?=strtolower(get_tour_departure_lang($departure_date, $week_days))?>)
                </td>
                
                <?php 
                    $contact_params = array(
                        'startdate' => $departure_date['start_date']
                    );
                    $params = get_tour_contact_params($tour, $contact_params);
                ?>
                
                <?php foreach ($accommodations as $accom):?>
                    
                	<?php if(!empty($departure_date['accommodations'])):?>
	                    <?php foreach ($departure_date['accommodations'] as $acc):?>
	                    <?php if($accom['id'] == $acc['id']):?>
	                    <td align="center">
	                        <?php if(!empty($acc['price_from'])):?>
	                        <div class="bpv-price-from"><?=bpv_format_currency($acc['price_from'])?></div>
	                        <?php else:?>
	                        <a href="<?=get_url(CONTACT_US_PAGE, $params)?>"><?=lang('contact_for_price')?></a>
	                        <?php endif;?>
	                    </td>
	                    <?php endif;?>
	                    <?php endforeach;?>
	                 <?php else:?>
	                 	<td align="center"><a href="<?=get_url(CONTACT_US_PAGE, $params)?>"><?=lang('contact_for_price')?></a></td>
	                 <?php endif;?>
                    
                <?php endforeach;?>
                
                <td align="center">
                    <button type="button" class="btn btn-bpv btn-book-now btn_book_t">
                    <span class="icon icon-btn-arrow-orange"></span>
                    <?=lang('book_tour')?>
                    </button>
                </td>
                
            </tr>
            <?php endforeach;?>
            <?php endif;?>
            
        <?php endif;?>
        
        <?php endforeach;?>
    </tbody>
</table>
<?php endif;?>

<div class="bpv-box-gray margin-top-10">
    <h4 class="bpv-color-title header"><?=lang('service_policy')?></h4>
    
    <div class="col-half">
        <h4 class="bpv-color-title"><?=lang('service_inclusion')?></h4>
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
    
    <div class="col-half">
        <h4 class="bpv-color-title"><?=lang('service_exclusion')?></h4>
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
    
    <div class="col-xs-12">
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
    <div class="cancellation-box col-xs-12 margin-top-20 margin-bottom-10">
        <h4 class="bpv-color-title"><?=lang('cancellation_policy')?></h4>
        <?=empty($tour['extra_cancellation']) || $is_no_refund ? $default_cancellation['content'] : $tour['extra_cancellation']?>
    </div>
    <?php endif;?>
</div>