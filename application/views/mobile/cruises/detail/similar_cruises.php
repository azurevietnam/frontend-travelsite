<div class="bpt-mb-list margin-top-20">
    <h2><?=$similar_title?></h2>
    <?=$list_cruises?>
</div>

<?php if(!empty($more_tour_text)):?>
<div class="container margin-top-10 margin-bottom-10">
    <a href="<?=$more_tour_link?>" class="btn btn-blue btn-block">
    <?=$more_tour_text?>
    <span class="icon icon-arrow-right-blue-sm margin-left-5"></span>
    </a>
</div>
<?php endif;?>