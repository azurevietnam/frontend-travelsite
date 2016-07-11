<div class="bpv-box margin-top-20">
    <h3 class="box-heading no-margin">
        <?=lang('field_faqs_by_destination')?>
    </h3>
    <?php foreach($destinations as $key=>$value):?>
        <h3 class="margin-left-15"><?=$key?></h3>
        <div class="list-group bpv-list-group">
            <?php foreach($destinations[$key] as $destination):?>
                <a class="list-group-item <?php if($destination['id'] == $current_destination_id) echo 'active'?>" href="<?=get_page_url(FAQ_DESTINATION_PAGE, $destination)?>">
                    <span class="glyphicon glyphicon-chevron-right" style="font-size: 10px; top: 0"></span>
                    <?=$destination['name']?>
                </a>
            <?php endforeach;?>
        </div>
    <?php endforeach;?>
</div>