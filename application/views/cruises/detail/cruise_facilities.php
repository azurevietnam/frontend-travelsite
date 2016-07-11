<div class="bpt-box margin-top-10">
    <h3 class="title text-highlight"><?=lang('cruise_facility_description')?><?=$cruise['name']?>:</h3>
    <h3 class="text-highlight header-title"><?=lang('facility_general')?></h3>
    <div class="facility">
        <ul>
            <?php foreach ($cruise_facilities[CRUISE_FACILITY_GENERAL] as $value) :?>
            <li>
                <span class="icon icon-check"></span>
                <?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?>
            </li>
            <?php endforeach ;?>
        </ul>
    </div>
    
    <h3 class="text-highlight header-title"><?=lang('facility_services')?></h3>
    <div class="facility">
        <ul>
            <?php foreach ($cruise_facilities[CRUISE_FACILITY_SERVICE] as $value) :?>
            <li>
                <span class="icon icon-check"></span>
                <?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?>
            </li>
            <?php endforeach ;?>
        </ul>
    </div>
    
    <h3 class="text-highlight header-title"><?=lang('facility_activities')?></h3>
    <div class="facility">
        <ul>
            <?php foreach ($cruise_facilities[CRUISE_FACILITY_ACTIVITY] as $value) :?>
            <li>
                <span class="icon icon-check"></span>
                <?=($value['important'] == STATUS_ACTIVE ? '<b>'.$value['name'].'</b>' : $value['name'])?>
            </li>
            <?php endforeach ;?>
        </ul>
    </div>
</div>

<div id="cruise_properties_deckplans"></div>