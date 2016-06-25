<?php foreach ($hotels as $hotel):?>
<?php
    $class_has_pro_off = ''; 
    if ( isset($hotel['price_from']) && $hotel['price_origin'] != $hotel['price_from'] && !empty($hotel['promotions'])) {
        $class_has_pro_off = ' has-pro-off';
    }
?>
<div class="bpv-item" onclick="go_url('<?=hotel_build_url($hotel, $search_criteria)?>')">
	<img class="pull-left" src="<?=get_image_path(HOTEL, $hotel['picture'],'160x120')?>">
	
	<div class="item-name<?=$class_has_pro_off?>">
    	<?=$hotel['name']?> <i class="icon star-<?=str_replace('.', '_', $hotel['star'])?>"></i>
    </div>
    
	<?php if(!empty($hotel['review_number'])):?>
        <div class="item-review-lst">
             <?=show_review($hotel, hotel_build_url($hotel), false, true)?>
        </div>
    <?php endif;?>
	
	<?php if( isset($hotel['price_from']) ):?>
		<div class="pull-right item-price">
			<?php if($hotel['price_origin'] != $hotel['price_from']):?>
				<span class="bpv-price-origin"><?=bpv_format_currency($hotel['price_origin'])?></span>
			<?php endif;?>
				<span class="bpv-price-from">
		    		<?=bpv_format_currency($hotel['price_from'])?>
	        	</span>
		</div>
	<?php if ($hotel['price_origin'] != $hotel['price_from'] && !empty($hotel['promotions'])):?>
       <span class="pro-off"><?=get_pro_off($hotel)?></span>
    <?php endif;?>
    <?php else:?>
    <?php $params = array('type'=>'hotel','des'=> $search_criteria['destination'],'hotel'=>$hotel['name'],'startdate'=>$search_criteria['startdate'],'night'=>$search_criteria['night']);?>
		
		<a type="button" class="btn btn-bpv btn-book-now btn-sm margin-top-5 pull-right margin-right-5" 
			href="<?=get_url(CONTACT_US_PAGE, $params)?>">
			<?=lang('m_contact_for_price')?>
		</a>
    <?php endif;?>
</div>
<?php endforeach;?>

<?//=load_hotel_map()?>

<script type="text/javascript">
/*
$('.pop-promotion').on('click', function (e) {
	$('.pop-promotion').not(this).popover('hide');
});
*/
</script>


