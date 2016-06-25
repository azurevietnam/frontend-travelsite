<!-- Modal -->

<div class="modal fade" id="data_overview" tabindex="-1" role="dialog" aria-labelledby="label_data_overview" aria-hidden="true">
  	<div class="modal-dialog modal-data-overview">
  		<button type="button" class="close close-data-overview" data-dismiss="modal" aria-hidden="true">
    		<span class="icon icon-btn-arrow-close"></span>
   	 	</button>
    	<div class="modal-content">
      		<div class="modal-body no-padding">
      			<div id="data_overview_loading" style="display:none">
      				<?=load_search_waiting(lang('data_loading'))?>
      			</div>
      			
      			<div id="data_overview_content">
      				
      			</div>
      		</div>
    	</div>   
 	</div>
</div>
