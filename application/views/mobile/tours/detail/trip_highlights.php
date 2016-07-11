<div class="container trip-highlight margin-top-10">
    <span class="text-highlight label-item"><?=lang('duration')?>:</span> <?=get_duration($tour['duration'])?> - 
    <span class="text-highlight label-item"><?=lang('type')?>:</span> <?=get_group_type($tour['group_type'])?>
    <div class="clearfix margin-top-10">
    <span class="text-highlight label-item"><?=lang('cruise_destinations')?>:</span> <?=$tour['route']?>
    </div>
    <div class="clearfix margin-top-10">
    <span class="text-highlight label-item"><?=lang('label_departure')?>:</span>
    <?php if(empty($tour['departure'])):?>
        <i><?=lang('lb_daily')?></i>
	<?php else:?>
        <?php $departure_title = $tour['cruise_name'].' '.lang('departure_dates').' '.get_text_depart_year($tour['departure'])?>
        <?=get_departure_short($tour['departure'], $departure_title)?>
        
        <div class="modal fade" id="cruiseScheduleModal" tabindex="-1" role="dialog" aria-labelledby="cruiseScheduleLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="cruiseScheduleLabel"><?=lang('label_cruise_schedule')?></h4>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <?=get_departure_full($tour['departure']);?>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <script>
        $('.tour_departure').click(function() {
        	$('#cruiseScheduleModal').modal();
        });
        </script>
    <?php endif;?>
    </div>
</div>

<?php if(!empty($highlights) || !empty($tour['tour_highlight'])):?>
    <?=$itinerary_highlight?>
<?php endif;?>