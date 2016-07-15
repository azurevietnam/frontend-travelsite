<?=$hotel['location']?>

<div class="clearfix margin-top-10">
    <?php if(!empty($hotel['description'])):?>
        <?php
        $desc = explode("\n", $hotel['description']);
        ?>

        <?php $descriptions = str_replace("\n", "<br>", $hotel['description'])?>
        <?php
        $is_show_more_desc = strlen($descriptions) > 100;

        $title = content_shorten($desc[0], 100);
        $inner_description = get_inner_substring($descriptions, $title);
        ?>

        <div class="description" id="short_desc" data-target="#full_desc">
            <?=$title?><span class="glyphicon glyphicon-plus-sign margin-left-10"></span>
        </div>
        <?php if($is_show_more_desc):?>
            <div class="description" id="full_desc" style="display:none">
                <?=$inner_description?>
            </div>
        <?php endif;?>
    <?php endif;?>
</div>

<div class="clearfix hotel-ids margin-top-10" data-id="<?=$hotel['id']?>">
    <span><?=lang('from')?>:</span> <span class="price-origin h-origin-<?=$hotel['id']?>"></span>
    <span class="price-from h-from-<?=$hotel['id']?>" style="display:none"><?=lang('na')?></span>
    <?=lang('per_room_night')?>
</div>

<script>
    $('#short_desc').bpvToggle(function(){
        var target = $(this).attr('data-target');
        if(!$(target).is(":visible")) {
            $(this).html('<?=$title?> <span class="glyphicon glyphicon-plus-sign margin-left-10"></span>');
        } else {
            $(this).html('<?=$title?> <span class="glyphicon glyphicon-minus-sign margin-left-10"></span>');
        }
    });
</script>