
<?php if(isset($page_header)):?>

<?php 
	$page_url = $this->uri->segment(1);
	$is_tours = $page_url == 'tours';
?>

<div id="page_title">
	<h1 class="highlight"><?=$page_header?><?php if($is_tours || !empty($page_header_desc)):?>:<?php endif;?></h1>
	
	<?php if($is_tours):?>
		<span><?=lang('tours_desc')?></span>
	<?php endif;?>

	<?php if(!empty($page_header_desc)):?>
	   <span><?=$page_header_desc?></span>
	<?php endif;?>
</div>
<?php endif;?>

<div id="contentMain">
	<?php if(isset($rich_snippet_infor)):?>
	<div xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Review-aggregate">
	   <meta property="v:itemreviewed" content="<?=$rich_snippet_infor['des_name']?>"/>
	   <span rel="v:rating">
	      <span typeof="v:Rating">
	      	<meta property="v:average" content="<?=($rich_snippet_infor['review_score']*5)/10?>"/>	
	      </span>
	   </span>
	   <meta property="v:count" content="<?=$rich_snippet_infor['review_numb']?>" />
	</div>
	<?php endif;?>

	<?=$contentMain?>
	
	<?=load_tour_contact()?>
</div>

<div id="contentLeft">
	<?=$tour_search_view?>
	
   	<?=$why_use?>
   	
	<?=$topDestinations?>
	
	<div id="tour_faq" class="left_list_item_block">
		<?=$faq_context?>
	</div>
</div>

<div id="loading_data" style="display:none;"><b><?=lang('process_data')?></b></div>

<div id="overlay_popup" onclick="close_popup()" class="overlay_popup"></div>
	
<div id="popup_container" class="popup_container">

<span onclick="close_popup()" class="icon btn-popup-close"></span>

<div class="popup_content" id="popup_content">

	<center><img alt="" src="<?=get_static_resources('/media/loading-indicator.gif')?>"></center>

</div>

</div>


<script>
	get_tour_prices_ajax("<?=$search_criteria['departure_date']?>", 
			"<?=CURRENCY_SYMBOL?>", "<?=lang('per_pax')?>", "<?=lang('offers')?>", "<?=lang('na')?>");
</script>