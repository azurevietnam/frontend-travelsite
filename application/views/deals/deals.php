<div class="container margin-bottom-20">
	
	<div class="row margin-bottom-20 mod-search">
		
		<div class="col-xs-12">
			<?=$bpv_ads?>
		</div>
		
		<?=$bpv_search?>
	</div>
	

	<div class="row">
		
		<div class="col-xs-12">
			<h1 class="bpv-color-title deal-page-title"><?=lang('deal_page_title')?></h1>
		
			<div class="bpv-tab">
				<ul class="nav nav-pills nav-tab hotel-deals">
					
					<?php foreach ($top_des as $key=>$des):?>
					
						<li id="tab_des_<?=$des['id']?>" <?php if($key == 0):?>class="active"<?php endif;?>>
					    	<a href="javascript:void(0)" onclick="select_des_deal(<?=$des['id']?>)" style="white-space:nowrap;">
					    		<?=$des['name']?>
					    	</a>
				        </li>
						
					<?php endforeach;?>
			        
			    </ul>
	    	</div>
    	
		</div>

	</div>
	
	<?php foreach ($top_des as $key=>$des):?>
    	<div class="des_promotion margin-top-10" id="des_<?=$des['id']?>" <?php if($key > 0):?> style="display:none"<?php endif;?>>
    	
    		<?=load_list_hotel_deals($des['hotels'])?>
    		
    	</div>
    <?php endforeach;?>
	
</div>

<!-- Modal -->
<div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog map-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<span class="icon btn-support-close"></span>
				</button>
				<h4 class="modal-title bpv-color-title" id="mapModalLabel"></h4>
			</div>
			<div class="modal-body">
				<div id="hotel_map"></div>
			</div>
		</div>
	</div>
</div>

<?=$bpv_register?>

<script type="text/javascript">

	function select_des_deal(id){

		$('.hotel-deals li').removeClass('active');

		$('.des_promotion').hide();

		$('#tab_des_'+id).addClass('active');

		$('#des_'+id).show();

	}

	$('.pop-promotion').on('click', function (e) {
		$('.pop-promotion').not(this).popover('hide');
	});

	<?php if(!empty($des_id)):?>
	$(function() {
		select_des_deal(<?=$des_id?>);
	});
	<?php endif;?>
</script>
