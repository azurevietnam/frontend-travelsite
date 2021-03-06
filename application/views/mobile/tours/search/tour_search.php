<div class="clearfix" id="tour_search_results">
    <?=$search_results?>
</div>

<!-- Modal -->
<div class="modal fade" id="see_more_deal" tabindex="-1" role="dialog" aria-labelledby="see_more_deal_title" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
      	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><span class="glyphicon glyphicon-remove"></span></span></button>

      	<h2 class="text-highlight">
      		<?=lang('label_book_with')?> '<span id="see_more_deal_tour_name"></span>' <span class="text-special"> - <?=lang('more_savings')?></span>
      	</h2>

		<div><?=lang('group_service_desc')?></div>
      </div>

      <div class="modal-body" id="see_more_deal_cnt">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-blue" data-dismiss="modal"><?=lang('lbl_close')?></button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
apply_ajax_paging();
</script>

