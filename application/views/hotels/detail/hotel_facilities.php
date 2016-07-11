<div class="bpt-box">
    <h2 class="text-highlight line-border">
        <?=lang('hotel_facility_description')?><?=$hotel['name']?>
    </h2>

    <h3 class="text-highlight header-title"><?=lang('facility_general')?></h3>
    <div class="facility clearfix">
        <ul class="list-unstyled">
            <?php foreach ($hotel_facilities[HOTEL_FACILITY_GENERAL] as $value) :?>
            <li class="col-xs-4 margin-bottom-10">
                <span class="icon icon-check"></span>
                <?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?>
            </li>
            <?php endforeach ;?>
        </ul>
    </div>

    <h3 class="text-highlight header-title"><?=lang('facility_services')?></h3>
    <div class="facility clearfix">
        <ul class="list-unstyled">
            <?php foreach ($hotel_facilities[HOTEL_FACILITY_SERVICE] as $value) :?>
            <li class="col-xs-4 margin-bottom-10">
                <span class="icon icon-check"></span>
                <?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?>
            </li>
            <?php endforeach ;?>
        </ul>
    </div>

    <h3 class="text-highlight header-title"><?=lang('facility_activities')?></h3>
    <div class="facility clearfix">
        <ul class="list-unstyled">
            <?php foreach ($hotel_facilities[HOTEL_FACILITY_ACTIVITY] as $value) :?>
            <li class="col-xs-4 margin-bottom-10">
                <span class="icon icon-check"></span>
                <?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?>
            </li>
            <?php endforeach ;?>
        </ul>
    </div>
</div>

