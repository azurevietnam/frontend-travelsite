<p><?=lang('hotel_facility_description')?><?=$hotel['name']?>:</p>
<h3 class="text-highlight"><?=lang('facility_general')?></h3>
<div class="row">
    <?php foreach ($hotel_facilities[CRUISE_FACILITY_GENERAL] as $value) :?>
    <div class="col-xs-6 margin-bottom-5">
        <span class="glyphicon glyphicon-ok text-choice"></span>
        <?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?>
    </div>
    <?php endforeach ;?>
</div>

<h3 class="text-highlight"><?=lang('facility_services')?></h3>
<div class="row">
    <?php foreach ($hotel_facilities[HOTEL_FACILITY_SERVICE] as $value) :?>
    <div class="col-xs-6 margin-bottom-5">
        <span class="glyphicon glyphicon-ok text-choice"></span>
        <?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?>
    </div>
    <?php endforeach ;?>
</div>

<h3 class="text-highlight"><?=lang('facility_activities')?></h3>
<div class="row">
    <?php foreach ($hotel_facilities[HOTEL_FACILITY_ACTIVITY] as $value) :?>
    <div class="col-xs-6 margin-bottom-5">
        <span class="glyphicon glyphicon-ok text-choice"></span>
        <?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?>
    </div>
    <?php endforeach ;?>
</div>

<div id="hotel_properties_deckplans"></div>