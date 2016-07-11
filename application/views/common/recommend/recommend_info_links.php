
<?php if(!empty($recommendations)): ?>
    <div class="bpt-recommended-block">
        <h3 class="title"><span class="icon icon-recommend-white margin-right-5"></span><?=lang('recommended')?></h3>

            <?php if($is_show_tour_recommened):?>
                <h3><?=lang('field_combine_excursion')?></h3>
                <ul class="list-unstyled">
                    <?php foreach($recommendations as $value):?>
                        <?php if($value['service_type'] == TOUR || $value['service_type'] == CRUISE):?>
                            <li class="clearfix">
                                <a href="<?=$value['link']?>">
                                    <div>
                                        <div class="col-xs-5" style="width: 37%">
                                            <img width="80px" height="60px" class="img-responsive" src="<?=$value['picture']?>">
                                        </div>
                                        <div class="col-xs-7 content">
                                            <div class="name">
                                                <?=$value['title']?>
                                            </div>
                                            <div class="description">
                                                <?=$value['description']?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right" style="padding-top: 20px">
                                        <span class="icon icon-arrow-right-orange"></span>
                                    </div>
                                </a>
                            </li>
                        <?php endif;?>
                    <?php endforeach;?>
                </ul>
            <?php endif;?>

            <?php if($is_show_hotel_recommened):?>
                <h3><?=lang('field_for_your_stay')?></h3>
                <ul class="list-unstyled">
                    <?php foreach($recommendations as $value):?>
                        <?php if($value['service_type'] == HOTEL):?>
                            <li class="clearfix">
                                <a href="<?=$value['link']?>">
                                    <div class="col-xs-5" style="width: 37%">
                                        <?php if(!empty($value['picture'])):?>
                                            <img width="80px" height="60px" class="img-responsive" src="<?=$value['picture']?>">
                                        <?php endif;?>
                                    </div>
                                    <div class="col-xs-7 content">
                                        <div class="name">
                                            <?=$value['title']?>
                                        </div>
                                        <div class="description">
                                            <?=$value['description']?>
                                        </div>
                                    </div>
                                    <div class="text-right" style="padding-top: 20px">
                                        <span class="icon icon-arrow-right-orange"></span>
                                    </div>
                                </a>
                            </li>
                        <?php endif;?>
                    <?php endforeach;?>
                </ul>
            <?php endif;?>

    </div>
<?php endif;?>