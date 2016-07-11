<div class="container">
	<div class="tailor_container clearfix margin-bottom-15 margin-top-15">
	    <?php if(!empty($schedule['avatar'])):?>
	        <img width="80px" height="80px" class="img-circle pull-left avatar" src ="<?=base_url('images/users/'.$schedule['avatar'])?>"/>
	    <?php else:?>
	        <img width="80px" height="80px" alt="<?=$schedule['sale_name']?>" class="img-circle pull-left avatar" src ="<?=base_url('media/team/hien-kim.jpg')?>"/>
	    <?php endif;?>
	
	    <div class="title" style="color: #FE8804; font-size: 16px; margin-top: 7px;"><?=empty($schedule['tailor_tour_title']) ? strtoupper(lang('field_tailor_make_tour_title_default'))  : strtoupper($schedule['tailor_tour_title'])?></div>
	
	    <div class="clearfix"></div>
	    <div class="text-center container margin-top-15">
	        <a href="<?= empty($url_tour) ? get_page_url(CUSTOMIZE_TOUR_PAGE) : get_page_url(CUSTOMIZE_TOUR_PAGE).$url_tour?>" class="btn btn-green btn-sm col-xs-12"><?=lang('field_tailor_make_a_trip')?> <span class="glyphicon glyphicon-circle-arrow-right"></span></a>
	    </div>
	</div>
</div>