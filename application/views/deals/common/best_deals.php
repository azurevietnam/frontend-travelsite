<div id="tabs">
    <div class="bpt-tab bpt-tab-tours" role="tabpanel">
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#halong_cruises" aria-controls="halong_cruises" role="tab" data-toggle="tab"><?=lang('halongbay_cruises')?></a></li>

            <li role="presentation"><a href="#mekong_cruises" aria-controls="mekong_cruises" role="tab" data-toggle="tab"><?=lang('mekong_cruises')?></a></li>

            <li role="presentation"><a href="#vietnam_hotels" aria-controls="vietnam_hotels" role="tab" data-toggle="tab"><?=lang('mnu_vietnam_hotels')?></a></li>
        </ul>
    </div>

    <div class="tab-content pull-right">
        <div role="tabpanel" id="halong_cruises" class="tab-pane active">
        	<?=$halong_deals?>
        </div>
        <div role="tabpanel" class="tab-pane" id="mekong_cruises">
        	<?=$mekong_deals?>
        </div>
        <div id="vietnam_hotels" role="tabpanel" class="tab-pane">

        </div>
        <div id="no_deal_avaiable"></div>
    </div>
</div>
<script>

	load_arrow_offer('#halong_cruises .best-tours', true);
	
	$('#tabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		load_arrow_offer('.active .best-tours', true);
	})
</script>