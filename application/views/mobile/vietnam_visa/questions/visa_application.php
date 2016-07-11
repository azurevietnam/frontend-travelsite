<div class="container">
    <h1 class="text-highlight"><?=lang('vietnam_visa_application_form')?></h1>
    <ul class="list-unstyled">
        <li style="font-size: 14px; font-weight: bold;" class="text-highlight">
            <label><?=lang('vietnam_immigration_form')?></label>
            <div style="font-size: 12px; color: #333; font-weight: normal;">
                <p><?=lang('vietnam_immigration_form_desc_1')?></p>
                <p><?=lang('vietnam_immigration_form_desc_2')?></p>
                <p><img width="16" height="16" src="<?=get_static_resources('/media/pdf.png')?>"> <a href="/visa_guides/download/Vietnam_Immigration_Form.pdf" style="font-weight: bold;"><?=lang('download_vietnam_immigration_form')?></a></p>
            </div>
        </li>
        <li style="font-size: 14px; font-weight: bold;" class="text-highlight">
            <label><?=lang('applying_voa_form_via_email')?></label>
            <div style="font-size: 12px; color: #333; font-weight: normal;">
                <p><?=lang('applying_voa_form_via_email_desc_1')?> <a href="mailto:<?=SUBSCRIBE_EMAIL?>"><?=SUBSCRIBE_EMAIL?></a></p>
                <p><?=lang('applying_voa_form_via_email_desc_2')?></p>
                <p><img width="16" height="16" src="<?=get_static_resources('/media/word.png')?>"> <a href="/visa_guides/download/form_apply.doc" style="font-weight: bold;"><?=lang('download_voa_form')?></a></p>
                <p class="price"><b><?=lang('lb_note')?>:</b></p>
                <table class="table table-bordered table-rates margin-bottom-10" style="font-size: 11px">
                    <thead>
                    <tr>
                        <td><b><?=lang('lb_full_name')?></b></td>
                        <td><b><?=lang('lb_date_of_birth')?></b></td>
                        <td><b><?=lang('lb_nationality')?></b></td>
                        <td><b><?=lang('lb_passport_number')?></b></td>
                        <td><b><?=lang('lb_date_of_expiry')?></b></td>
                        <td><b><?=lang('lb_arrival_date')?></b></td>
                        <td><b><?=lang('lb_arrival_airport')?></b></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php for($i=0; $i<3; $i++):?>
                        <tr>
                            <?php for($j=0; $j<7; $j++):?>
                                <td>&nbsp;&nbsp; ...</td>
                            <?php endfor;?>
                        </tr>
                    <?php endfor;?>
                    </tbody>
                </table>
                <p><?=lang('vietnam_immigration_form_required')?></p>
                <p><?=lang('date_format_example')?> <?=date("d/m/Y")?></p>
                <p><?=lang('arrival_airport_desc')?></p>
            </div>
        </li>
    </ul>
    <div class="related-info">
        <h3><?=lang('related_visa_information')?></h3>
        <?=$top_visa_questions?>
    </div>
</div>