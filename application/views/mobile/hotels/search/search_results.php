<div class="container">
    <?php if(!empty($destination) && !empty($search_criteria)):?>
        <h2 class="text-highlight">
            <?='<b>' . $number_hotels . '</b> ' . lang('field_hotels_in') . '<b> ' . $destination['name'] . '</b>, ' . lang('field_start_date_on') . ': <b>' . $search_criteria['start_date'] . '</b>' ?>
        </h2>
    <?php endif;?>
</div>
<?=isset($filtered_items) ? $filtered_items : ''?>

<?php if(!empty($list_hotels)):?>

    <div class="margin-bottom-10 clearfix">
        <div class="col-xs-6"></div>
        <div class="col-xs-6">
            <button type="button" class="btn btn-default btn-block btn-filter" data-target="#bpv-sort">
                <?=lang('sort_by')?> <span class="caret"></span>
            </button>
        </div>
    </div>

    <div id="bpv-sort" class="bpv-s-content">
        <?=$sort_by?>
    </div>
    <hr>

    <?=$list_hotels?>

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
