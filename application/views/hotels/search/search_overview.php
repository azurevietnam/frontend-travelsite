<div class="search-overview">
    <h2 class="text-highlight">
        <?=lang('lbl_search_overview')?>
    </h2>

    <div class="row">
        <div class="col-xs-5"><?=lang('destination')?>:</div>
        <div class="col-xs-7"><label><?=$search_criteria['destination']?></label></div>
    </div>

    <div class="row">
        <div class="col-xs-5"><?=lang('departure_date')?>:</div>
        <div class="col-xs-7"><label><?=date(DATE_FORMAT, strtotime($search_criteria['start_date']))?></label></div>
    </div>

    <?php if(!empty($search_criteria['stars'])):?>
        <div class="row">
            <div class="col-xs-5"><?=lang('hotel_star')?>:</div>
            <div class="col-xs-7" style="margin-left: -10px">
                <?php foreach($search_criteria['stars'] as $value):?>
                    <label class="col-xs-4"><?=$value?>*</label>
                <?php endforeach;?>
            </div>
        </div>
    <?php endif;?>

    <div class="row">
        <div class="col-xs-7 col-xs-offset-5">
            <button class="btn btn-blue btn-block" type="button" onclick="javascript: $('.search-overview').hide(); $('.search-form').show();"><?=lang('lbl_change_search')?></button>
        </div>
    </div>

</div>