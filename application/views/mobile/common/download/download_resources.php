<?php if(!empty($files)):?>
<?php if(!empty($title)):?>
<h2 class="text-highlight margin-top-0"><?=$title?></h2>
<?php endif;?>

<div class="row">
<?php foreach($files as $value):?>
    <div class="col-xs-12 margin-bottom-10">
        <a href="<?=site_url('ajax/download/index/' . $value['service'] . '/' . $value['name'])?>" title="<?=$value['description']?>">
        <span class="glyphicon glyphicon-download-alt margin-right-5"></span><?=$value['name']?>
        </a>
    </div>
<?php endforeach?>
</div>
<?php endif;?>