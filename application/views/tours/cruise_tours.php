<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php $desc = get_header_desc($action)?>

<div id="page_title">
 	<?php $page_title = str_replace(lang('label_cheap'), lang('label_budget'), $desc['header']);?>
	<h1 class="highlight"><?=$page_title?><?php if($desc['desc'] != ''):?>:<?php endif;?></h1>

	<span><?=$desc['desc']?></span>
	  
</div>


<?php 
	$is_main_tabs = $action == HALONG_BAY_CRUISES || $action == MEKONG_RIVER_CRUISES;
?>

<?php 
	if ($this->session->userdata('MENU') == MNU_HALONG_CRUISES){
		$cruise_location = lang('label_halong_bay_cruises');
		$cruise_port_str = "halongcruises";
	}elseif($this->session->userdata('MENU') == MNU_MEKONG_CRUISES){
		$cruise_location = lang('label_mekong_river_cruises');
		$cruise_port_str = "mekongcruises";
	}

?>
 

<div id="contentMain">
<?php if(isset($rich_snippet_infor)):?>
<div xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Review-aggregate">
   <meta property="v:itemreviewed" content="<?=$page_header?>"/>
   <span rel="v:rating">
      <span typeof="v:Rating">
      	<meta property="v:average" content="<?=($rich_snippet_infor['review_score']*5)/10?>"/>	
      </span>
   </span>
   <meta property="v:count" content="<?=$rich_snippet_infor['review_numb']?>" />
</div>
<?php endif;?>

<?php if($is_main_tabs):?>	

<?php if($best_tour):?>

	<div id="best-deal">
		<div class="header">
			<h2 class="special"><span class="icon icon_hot_deal"></span><?=lang('today_hot_deals')?></h2>
		</div>
		<div class="content">
			
			<div class="deal-content">
				
				<div class="deal-name">
					<span class="highlight"><a href="<?=url_builder(TOUR_DETAIL, $best_tour['url_title'], true)?>"><?=$best_tour['name']?></a></span>
					<?=by_partner($best_tour)?>
				</div>
				
				<div class="deal-row" style="margin-top: 3px">
				
					<div class="group_price">
						<span class="b_discount"><?=CURRENCY_SYMBOL?><?=number_format($best_tour['from_price'], CURRENCY_DECIMAL)?></span>
		        		
			        	<span class="price_from"><?=CURRENCY_SYMBOL?><?=number_format($best_tour['selling_price'], CURRENCY_DECIMAL)?></span>	
			        						
						<span><?=lang('per_pax')?></span>
					</div>
					
				</div>
				
	
				<?php if($best_tour['offer_note'] != ''):?>
					<div class="deal-row special deal-block">
						<div class="special"><b><?=lang('label_special_offers')?></b></div>
						<?php 
							$offers = explode("\n", $best_tour['offer_note']);
						?>
						<ul class="deal-offers">
							
							<?php foreach ($offers as $offer):?>
								<li>
									<span class="icon icon_checkmark"></span>	
									<a class="special best_tour" href="javascript:void(0)"><?=$offer?> &raquo;</a>
								</li>
							<?php endforeach;?>
						</ul>		
					</div>
				<?php endif;?>	
				
				
					
					
				<?php if($best_tour['expiry_date'] != ''):?>	
				
				<div class="deal-row">
					<span class="icon icon_clock"></span>
					<span><b><?=get_expired_text($best_tour['expiry_date'])?></b></span>	
				</div>
				
				<?php endif;?>
				
				<?php if ($best_tour['review_number'] > 0):?>	
					<div class="deal-row"><?=lang('reviewscore')?>:
					<?=get_full_review_text($best_tour)?>
					</div>
				<?php endif;?>
				
				
				 <div class="deal-row short_description">
				 	<?=strip_tags(character_limiter($best_tour['brief_description'], 100))?>
				 </div>
				
				<div class="btn_general btn_see_deal" id="check_rate_<?=$best_tour['id']?>">
				 	<span><?=lang('see_deal')?></span>
				 	<span class="icon icon-go"></span>
				 </div>
			</div>
			
			<div class="deal-image">
				<img width="375" height="250" src="<?=$this->config->item('tour_375_250_path').$best_tour['picture']?>" alt="<?=$cruise_location.' '.lang('label_hot_deals')?>"></img>
			</div>
			
		</div>
	</div>
<?php endif;?> 

<?php endif;?> 


<?php if(count($tour_hot_deals) > 0):?>

<div class="cruise_top_deals grayBox" <?php if($is_main_tabs && $best_tour):?> <?php else:?>style="border-width: 1px;width:718px; padding-bottom: 10px; margin-top:0"<?php endif;?>>
	<h2 class="highlight">
		<?php 
			$hd_text = lang('label_top_cruise_deals');
			if($is_main_tabs) {
				$hd_text = lang('label_top_deals').' - '.($action == HALONG_BAY_CRUISES ? lang('label_halong_bay_cruises') : lang('label_mekong_river_cruises'));
			}
		?>
		<span class="icon deal_icon"></span><?=$hd_text?>
	</h2>
	
	<?php 
		$count_index = 1;
	?>
	    	
	<?php foreach ($tour_hot_deals as $tour):?>
		<div class="deal_item">
			<div class="deal_item_price">
				<span class="b_discount"><?=CURRENCY_SYMBOL?><?=number_format($tour['from_price'], CURRENCY_DECIMAL)?></span>
				<span class="price_from" style="font-size:14px;"><?=CURRENCY_SYMBOL?><?=number_format($tour['selling_price'], CURRENCY_DECIMAL)?></span><br>
			</div>
			
			<div class="deal_item_content">				
				<a href="<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>"><img width="135" height="90" class="deal_item_image" src="<?=$this->config->item('tour_135_90_path').$tour['picture']?>" alt="<?=$tour['name']?>"></img></a>
			
				
				<div class="row">
					<a <?php if(strlen($tour['name']) > TOUR_NAME_HOT_DEAL_LIMIT):?> title="<?=$tour['name']?>" <?php endif;?> href="<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>"><b><?=character_limiter($tour['name'], TOUR_NAME_HOT_DEAL_LIMIT)?></b></a><br/>				
				</div>
				
				<?php if ($tour['offer_note'] != ''):?>
					
						<?php 
							$offers = explode("\n", $tour['offer_note']);
						?>
						<?php foreach ($offers as $offer):?>
								<div class="row special">
									<a class="special hot_deal_<?=$tour['id']?>_<?=$tour['promotion_id']?>" href="javascript:void(0)"><?=$offer?></a>
								</div>
						<?php endforeach;?>
						
				<?php endif;?>
		
			</div>
		</div>
		
		<?php 
			$count_index++;
			
			if ($count_index > 4) break;
		?>
		
	<?php endforeach;?>
		
</div>  
<?php endif;?>

  
 <div id="recommended_cruises" style="width: 100%; float: left;">
 	<?=$recommended_cruises?>
 </div>

</div>

<div id="contentLeft">
	<?=$tour_search_view?>
    
    <?=$why_use?>

	<?=$topDestinations?>
	
	<div id="tour_faq" class="left_list_item_block">		
		<?=$faq_context?>
	</div>
</div>


 <div class="lst_all_cruises">
 	
 	<?=$all_cruises_view?>
 	
 </div>	

<div id="overlay_popup" onclick="close_popup()" class="overlay_popup"></div>
	
<div id="popup_container" class="popup_container">

	<span onclick="close_popup()" class="icon btn-popup-close"></span>
	
	<div class="popup_content" id="popup_content">
	
		<center><img alt="" src="<?=get_static_resources('/media/loading-indicator.gif')?>"></center>
	
	</div>

</div>
 
<script type="text/javascript">

function get_cruise_from_price(){
	var current_date = getCookie('departure_date');

	if (current_date == null || current_date ==''){
		current_date = "<?=$search_criteria['departure_date']?>";
	}
	
	$.ajax({
		url: "/tours/get_cruise_price_from/",
		type: "POST",
		cache: true,
		dataType: "json",
		data: {	
			"tour_ids": "<?=$tour_ids?>",
			"departure_date": current_date						
		},
		success:function(value){
			
			for(var i = 0; i < value.length; i++){

				var tour = value[i];
				var fromPrice = "<?=CURRENCY_SYMBOL?>" + tour.f_price;
				if(tour.f_price == 0) {
					fromPrice = "<?=lang('na')?>";
					$('.'+ tour.id + 'from_label').html('');
				}
				
				$('.'+ tour.id + 'from_price').html(fromPrice);
				
				$('.'+ tour.id + 'block_price').show();
				
				if(tour.d_price != 0) {
					$('.'+ tour.id + 'promotion_price').html(tour.d_price);
					$('.'+ tour.id + 'block_pro_price').show();
				} else {
					$('.'+ tour.id + 'block_pro_price').hide();
				}
							
			}
			
		}
	});

	}

$(function() {

	get_cruise_from_price();
	
	<?php if (isset($best_tour)):?>
	
		$("#check_rate_<?=$best_tour['id']?>").click(function(){

			//_gaq.push(['_trackEvent', '<?=$desc['header']?>', 'See hot deal', '<?=$best_tour['name']?>', 1, true]);
			
			window.location = "<?=url_builder(TOUR_DETAIL, $best_tour['url_title'], true)?>";
			
		});

		<?php
			
			$promotion_title = htmlspecialchars($best_tour['promotion_name'], ENT_QUOTES);
		?>
		
		var dg_content = '<?=get_promotion_condition_text($best_tour)?>';
		var d_help = '<span class="special" style="font-size: 13px;"><?=$promotion_title?>:</span>';
		$(".best_tour").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});

		<?php foreach ($tour_hot_deals as $key=>$tour):?>
			<?php if($key > 4) break;?>
			<?php
				
				$promotion_title = htmlspecialchars($tour['promotion_name'], ENT_QUOTES);
			?>
			
			var dg_content = '<?=get_promotion_condition_text($tour)?>';
			var d_help = '<span class="special" style="font-size: 13px;"><?=$promotion_title?>:</span>';
			$(".hot_deal_<?=$tour['id']?>_<?=$tour['promotion_id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});

		<?php endforeach;?>
		
	<?php endif;?>


});

</script>