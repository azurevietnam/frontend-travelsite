<div class="container">
<h2 class="text-highlight">
	<?='<b>'.$cnt_total_results.'</b>'.($cnt_total_results > 1 ? ' '.lang('label_tours') : ' '.lang('label_tour'))?>
  	<?=lang_arg('label_search_results_summary', $search_criteria['destination'], date(DATE_FORMAT_DISPLAY, strtotime($search_criteria['departure_date'])))?>
  	<?php if(has_filters($search_criteria)):?>
  		<small class="text-highlight"><?=lang('label_match_following_filters')?></small>
  	<?php endif;?>	 	
</h2>
</div>
<?=isset($filtered_items) ? $filtered_items : ''?>

<?php if(!empty($list_tours)):?>

    <div class="margin-bottom-10 clearfix">
        <div class="col-xs-6">
            <button type="button" class="btn btn-default btn-block btn-filter" data-target="#bpv-sort">
        	    <?=lang('sort_by')?> <span class="caret"></span>
        	</button>
        </div>
        <div class="col-xs-6">
            <button type="button" class="btn btn-default btn-block btn-filter" data-target="#bpv-filter">
        	    <?=lang('filter_results')?> <span class="caret"></span>
        	</button>
    	</div>
    </div>

    <div id="bpv-sort" class="bpv-s-content">
        <?=$sort_by?>
    </div>
    
    <div id="bpv-filter" class="bpv-s-content">
        <?=$search_filters?>
	</div>
	
	<?=$list_tours?>
	
	<?=$search_paging?>
	
	<script type="text/javascript">
        $('.btn-filter').bpvToggle(function(data) {
            if( $('#bpv-sort').is(":visible") && data['id'] != '#bpv-sort') {
                $('#bpv-sort').hide();
            }
            if( $('#bpv-filter').is(":visible") && data['id'] != '#bpv-filter') {
                $('#bpv-filter').hide();
            }
        });
    </script>
<?php else:?>
	<div class="alert alert-warning" role="alert">
		<h2><span class="glyphicon glyphicon-warning-sign"></span> <?=lang('lbl_filter_empty')?></h2>
	</div>
<?php endif;?>
