<?php if(!empty($navigations)):?>
<ol class="breadcrumb">
    <?php $lastElement = end($navigations);?>
    <?php foreach ($navigations as $key => $value):?>
    <?php if($value == $lastElement) continue;?>
    <li><a href="<?=$value['link']?>"><?=$value['title']?></a><span class="glyphicon glyphicon-chevron-right"></span></li>
    <?php endforeach;?>
    <li><?=$lastElement['title']?></li>
    
    <?php if($page != HOTEL_BOOKING_PAGE && $page != TOUR_BOOKING_PAGE):?>
    	<li class="pull-right" style="font-size: 13px;" id="divCart"></li>
    <?php endif;?>
</ol>
<?php endif;?>
