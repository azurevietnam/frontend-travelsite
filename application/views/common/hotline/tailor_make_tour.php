<div class="tailor_container clearfix">
    <div class="col-xs-2 avatar">
        <?php if(!empty($schedule['avatar'])):?>
            <img width="90px" height="90px" class="img-circle" src ="<?=base_url('images/users/'.$schedule['avatar'])?>"/>
        <?php else:?>
            <img width="90px" height="90px" alt="<?=$schedule['sale_name']?>" class="img-circle" src ="<?=base_url('media/team/hien-kim.jpg')?>"/>
        <?php endif;?>
    </div>
    <div class="col-xs-10 content">
        <div class="title">
        	<?=empty($schedule['tailor_tour_title']) ? strtoupper(lang('field_tailor_make_tour_title_default'))  : strtoupper($schedule['tailor_tour_title'])?>
        </div>
        
        <div class="margin-bottom-15">
        	<?=empty($schedule['tailor_tour_description']) ? lang('field_tailor_make_tour_description_default')  : $schedule['tailor_tour_description']?> 
        </div>
        
        <div class="text-center">
            <a href="<?= empty($url_tour) ? get_page_url(CUSTOMIZE_TOUR_PAGE) : get_page_url(CUSTOMIZE_TOUR_PAGE).$url_tour?>" class="btn btn-green"><?=lang('field_tailor_make_a_trip')?> <span class="glyphicon glyphicon-circle-arrow-right"></span></a>
        </div>
    </div>

</div>