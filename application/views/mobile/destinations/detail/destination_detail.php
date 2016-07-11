<?=$photo_slider?>
<div class="container">
    <h1 class="highlight"><b><?=$destination['name']?>
            <?php if(!empty($destination['title'])) echo ' - '.$destination['title']?></b>
    </h1>
    <p><?=$destination['short_description']?></p>

    <p><?=$destination['full_description']?></p>

    <?php if(!empty($travel_tips)):?>
        <?=$travel_tips?>
    <?php endif;?>

    <?=$tailor_make_tour?>
    <?=$destination_categories?>
</div>

