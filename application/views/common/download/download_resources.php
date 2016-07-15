<?php if(!empty($files)):?>
<div class="bpt-download margin-bottom-20 margin-top-10">
    <?php if(!empty($title)):?>
        <h2 class="text-highlight header-title">
            <?=$title?>
        </h2>
    <?php endif;?>

    <div class="row">
    <?php foreach($files as $value):?>
        <div class="col-xs-6 margin-bottom-10">
            <a href="<?=site_url('ajax/download/index/' . $value['service'] . '/' . $value['name'])?>" title="<?=$value['description']?>">
            <span class="glyphicon glyphicon-download-alt margin-right-5"></span><?=$value['name']?>
            </a>
        </div>
    <?php endforeach?>
    </div>
</div>
<?php endif;?>