<div class="bpt-tab bpt-tab-tours" role="tabpanel">
    <ul class="nav nav-tabs" role="tablist">
        <?php foreach ($hotel_by_top_destinations as $key => $value):?>
                <li role="presentation" <?php if($value['is_first']):?>class="active"<?php endif;?>>
                    <a href="#page_<?=$key?>" aria-controls="page_<?=$key?>" role="tab" data-toggle="tab"><?=$value['name']?></a>
                </li>
        <?php endforeach;?>
    </ul>
</div>

<div class="tab-content">
    <?php foreach ($hotel_by_top_destinations as $key => $value):?>
            <div role="tabpanel" class="tab-pane <?php if($value['is_first']):?>active<?php endif;?>" id="page_<?=$key?>">
                <?=$value['list_hotels']?>
                <div class="pull-right">
                    <a href="<?=get_page_url(HOTELS_BY_DESTINATION_PAGE, $value)?>" class="bpt-see-more"><?=lang('field_more_hotel_in', $value['name'])?><span class="icon icon-arrow-right-blue-sm margin-left-5"></span></a>
                </div>
            </div>
    <?php endforeach;?>
</div>
<script type="text/javascript">
get_hotel_price_from();
</script>