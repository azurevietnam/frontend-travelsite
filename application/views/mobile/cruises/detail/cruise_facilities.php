<p><?=lang('cruise_facility_description')?><?=$cruise['name']?>:</p>
<h3 class="text-highlight"><?=lang('facility_general')?></h3>
<div class="row">
    <?php foreach ($cruise_facilities[CRUISE_FACILITY_GENERAL] as $value) :?>
    <div class="col-xs-6">
        <span class="glyphicon glyphicon-ok text-choice"></span>
        <?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?>
    </div>
    <?php endforeach ;?>
</div>

<h3 class="text-highlight"><?=lang('facility_services')?></h3>
<div class="row">
    <?php foreach ($cruise_facilities[CRUISE_FACILITY_SERVICE] as $value) :?>
    <div class="col-xs-6">
        <span class="glyphicon glyphicon-ok text-choice"></span>
        <?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?>
    </div>
    <?php endforeach ;?>
</div>

<h3 class="text-highlight"><?=lang('facility_activities')?></h3>
<div class="row">
    <?php foreach ($cruise_facilities[CRUISE_FACILITY_ACTIVITY] as $value) :?>
    <div class="col-xs-6">
        <span class="glyphicon glyphicon-ok text-choice"></span>
        <?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?>
    </div>
    <?php endforeach ;?>
</div>

<div id="cruise_properties_deckplans"></div>