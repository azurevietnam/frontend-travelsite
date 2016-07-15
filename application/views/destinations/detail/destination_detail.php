<div class="bpt-col-right pull-right travel-guide-fontsize">
    <h1 class="highlight"><b><?=$destination['name']?>
        <?php if(!empty($destination['title'])) echo ' - '.$destination['title']?></b>
    </h1>
    <p><?=$destination['short_description']?></p>
    <?=$photo_slider?>
    <p><?=$destination['full_description']?></p>

    <?php if(!empty($travel_tips)):?>
        <?=$travel_tips?>
    <?php endif;?>

    <?=$tailor_make_tour?>
</div>
<div class="bpt-col-left pull-left">
    <?=$destination_categories?>
    <?=$tripadvisor?>
</div>
