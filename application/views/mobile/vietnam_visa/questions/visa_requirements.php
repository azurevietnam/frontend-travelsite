<div class="container">
    <h1 class="text-highlight"><?=lang('vietnam_visa_rquirements')?></h1>
    <p><?=lang('please_check_whether_need_a_voa')?></p>
    
    <div class="visa-requirement-box clearfix margin-bottom-20">
        <div class="col-xs-12 margin-bottom-10">
            <label class="text-highlight" style="padding-left: 10px; font-size: 14px;"><?=lang('label_select_nationality')?></label>
            <select class="form-control" name="nationality" id="ck_nationality">
                <option value="">-- <?=lang('please_select_nationality')?> --</option>
                <?php foreach ($countries as $country) :?>
                    <?php
                    $url_ct_name = strtolower(trim($country['name']));
                    $url_ct_name = str_replace(' ', '-', $url_ct_name);
                    $url_ct_name .= '.html';
                    ?>
                    <option value="<?=$url_ct_name?>"><?php echo $country['name']?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="col-xs-12 margin-bottom-10">
            <button onclick="check_requirements()" class="btn btn-blue btn-block"><?=lang('check_requirements')?></button>
        </div>
    </div>
    
    <p class="margin-bottom-20"><?=lang('check_requirements_desc')?></p>
    
    <div class="related-info">
        <h3 style="padding-left: 0"><?=lang('related_visa_information')?></h3>
        <?=$top_visa_questions?>
    </div>
</div>