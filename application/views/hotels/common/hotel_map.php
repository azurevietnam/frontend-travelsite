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
				
				<div class="star-filter" style="border: 1px solid #94c9ec;">
					<?php for($i=1; $i <= 5; $i++):?>
					
						<div class="checkbox">
			 				<label>
			 					<input type="checkbox" class="hm-filter-stars" value="<?=$i?>" checked="checked" onclick="filter_map_data()">
			 					<span class="icon star-<?=$i?>"></span>
			 				</label>
			 			</div>
					
					<?php endfor;?>
				</div>
				
			</div>
			
			 <div class="modal-footer">
			 	<div class="row">
			 		<div class="col-xs-6 text-left">
						<style>
							.icon-hotel1{
								background: url("/media/icon/hotel-marker.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
								display: inline;
								height: 25px;
								width: 100px;
								float:left;
								padding-left:30px;
								margin-top:10px;
							}
							.icon-place1{
								background: url("/media/icon/des_icon.png") no-repeat scroll 0 0 rgba(0, 0, 0, 0);
								display: block;
								float: left;
								height: 25px;
								width: 90px;
								padding-left:25px;
								margin-top:10px;
							}
						</style>
			 			<span class="icon-hotel1"><?=lang('hm_hotel')?></span>
			 			<span class="icon-place1"><?=lang('hm_destination')?></span>
						<div class="checkbox checkbox-inline">
			 				<label>
			 					<input type="checkbox" id="hm_show_hotel" checked="checked" onclick="filter_map_data()"> <?=lang('hm_view_hotel')?>
			 				</label>
			 			</div>
			 			<div class="checkbox checkbox-inline" style="margin-top: 10px;">
			 				<label>
			 					<input type="checkbox" id="hm_show_des" onclick="filter_map_data()"> <?=lang('hm_view_destination')?>
			 				</label>
			 			</div>
			 		</div>
			 		
			 		<div class="col-xs-3 hm-area-info" style="margin-top: 10px; padding-left: 80px;visibility:hidden">
			 			<label><?=lang('hm_view_area')?>:</label>
			 		</div>
			 		
			 		
			 		<div class="col-xs-2 hm-area-info" id="hm_area" style="visibility:hidden">
			 		
			 		</div>
					
					<div class="col-xs-1">
						<button type="button" class="btn btn-primary" data-dismiss="modal"><?=lang('btn_close')?></button>
					</div>
					
			 	</div>
			 </div>
			
		</div>
	</div>
</div>