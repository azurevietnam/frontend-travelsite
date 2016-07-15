<form name="frm" method="post" id="frmRequest" class="form-horizontal">
    <div class="bpt-contact">
        <div class="row">
            <div class="col-xs-4">
                <?php if(empty($schedule['avatar'])):?>
                    <img class="img-circle img-responsive" src ="<?=site_url('media/team/hien-kim.jpg')?>"/>
                <?php else:?>
                    <img class="img-circle img-responsive" src ="<?=site_url('images/users/'. $schedule['avatar'])?>"/>
                <?php endif;?>
            </div>
            <h1 class="col-xs-8">
                <?=$schedule['tailor_tour_title']?>
            </h1>
        </div>
        <div class="col-xs-12 margin-top-10 no-padding"><?=$schedule['tailor_tour_description']?></div>

        <div class="clearfix"></div>

        <ol class="no-padding">
            <?php if(!empty($tour)):?>
                <h3 class="text-highlight"><li><?=lang('field_your_selected_tour')?>:</li></h3>
                <div>
                    <?=$tour['name']?>&nbsp; &nbsp; &nbsp;
                    <a href="<?=get_page_url(TOUR_DETAIL_PAGE, $tour)?>" target="_blank"> <?=lang('field_view_detail')?><span class="glyphicon glyphicon-chevron-right"></span></a>
                </div>
            <?php endif;?>
            <input type="hidden" name="tour_name" value="<?=empty($tour['name']) ? '' : $tour['name']?>" />

            <div class="clearfix"></div>

            <h3 class="text-highlight"><li><?=lang('field_how_people_in_group')?></li></h3>

            <div class="form-group">
                <div class="col-xs-4">
                    <label for="adults" class="control-label" style="min-height: 35px"><?=lang('adults')?>:</label>
                    <div>
                        <select name="adults" class="form-control">
                            <?php for ($i = 1; $i <= ADULT_LIMIT; ++$i) :?>
                                <option value="<?=$i?>" <?=set_select('adults', $i, $i=='2'? true: false)?>><?=$i?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                </div>

                <div class="col-xs-4">
                    <label for="children" class="control-label" style="min-height: 35px"><?=lang('children')?>:</label>
                    <div>
                        <select name="children" class="form-control">
                            <?php for ($i = 0; $i <= CHILDREN_LIMIT; ++$i) :?>
                                <option value="<?=$i?>" <?=set_select('children', $i)?>><?=$i?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                </div>

                <div class="col-xs-4">
                    <label for="infants" class="control-label" style="min-height: 35px"><?=lang('infants')?>:</label>
                    <div>
                        <select name="infants" class="form-control">
                            <?php for ($i = 0; $i <= CHILDREN_LIMIT; ++$i) :?>
                                <option value="<?=$i?>" <?=set_select('infants', $i)?>><?=$i?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

            <h3 class="text-highlight"><li><?=lang('field_date_arrival')?>:<?=mark_required()?></li></h3>
            <div class="col-xs-12 no-padding"><?=lang('field_tell_us_approximate_date')?></div>

            <div class="clearfix"></div>

            <div class="form-group" class="departure_date_customize" id="arrival">
                    <div class="col-xs-10">
                        <input class="form-control" type="text" class="departure_date_customize" name="departure_date_customize" id="departure_date_customize" placeholder="dd/mm/yyyy" value="<?=set_value('departure_date_customize')?>"/>
                    </div>
                    <div class="col-xs-12"><?=form_error('departure_date_customize')?></div>
            </div>

            <div class="clearfix"></div>

            <h3 class="text-highlight"><li><?=lang('field_tour_duration')?>:<?=mark_required()?></li></h3>

            <div class="form-group">
                <div class="col-xs-10">
                    <select name="tour_duration" class="form-control" id="tour_duration">
                        <option value=""><?=lang('label_please_select')?></option>
                        <?php for ($i = 1; $i <= 30; ++$i) :?>
                            <?php
                            $day_text = 'days';
                            if ($i == 1) $day_text = 'day';
                            ?>
                            <option value="<?=$i?>" <?=set_select('tour_duration', !empty($tour) && $tour['duration'] == $i)?>><?=$i. ' '.$day_text?></option>
                        <?php endfor;?>
                    </select>
                </div>
            </div>
            <?=form_error('tour_duration')?>
            <div class="clearfix"></div>

            <h3 class="text-highlight"><li><?=lang('field_accomodation')?>:<?=mark_required()?></li></h3>

            <div class="list-group" id="tour_accommodation">
                    <?php foreach ($tour_customize_class as $key=>$value):?>
                        <div class="checkbox no-margin list-group-item">
                            <label class="no-padding margin-right-10">
                                <input type="radio" name="tour_accommodation" value="<?=$key?>" <?=set_radio('tour_accommodation')?>>
                                <span class="margin-left-10"><?=lang($value['name'])?></span>
                            </label>
                            <?php if(empty($value['price_to'])):?>
                                (>$<b id="price_from<?=$key?>" price_from="<?=$value['price_from']?>"><?=$value['price_from']?></b>)
                            <?php else:?>
                                ($<b id="price_from<?=$key?>" price_from="<?=$value['price_from']?>"><?=$value['price_from']?></b>- $<b id="price_to<?=$key?>" price_to="<?=$value['price_to']?>"><?=$value['price_to']?></b>)
                            <?php endif;?>
                        </div>
                    <?php endforeach;?>
            </div>

            <?=form_error('tour_accommodation')?>
            <div class="clearfix"></div>


            <h3 class="text-highlight"><li><?=lang('field_what_ideal_trip')?></li></h3>
            <div><?=lang('field_tell_us_where_want_visit')?></div>
            <div class="clearfix"></div>

            <?php foreach ($parent_dess as $country):?>
                <div class="list-group">
                    <h4><?=$country['name']?></h4>
                    <?php foreach ($dess as $city):?>
                        <?php if($city['parent_id'] == $country['id']):?>
                            <div class="checkbox no-margin list-group-item">
                                <label>
                                    <input type="checkbox" value="<?=$city['name']?>" <?=set_checkbox('destination_visit', $city['name'])?> name="destination_visit[]">&nbsp;<?=$city['name']?>
                                </label>
                            </div>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
            <?php endforeach;?>

            <div class="clearfix"></div>

            <div class="form-group container">
                <div class="col-xs-11 no-padding">
                    <textarea class="form-control" name="message" cols="66" rows="5" placeholder="<?=lang('field_placehold_message')?>"><?=set_value('message')?></textarea>
                </div>
                <div class="col-xs-1 no-padding">
                    <?=mark_required()?>
                </div>
                <div class="col-xs-12" style="margin-left: -15px"><?=form_error('message')?></div>
            </div>

            <div class="clearfix"></div>

            <h3 class="text-highlight"><li><?=lang('field_contact_details')?>:</li></h3>
            <div class="row">
                <div class="col-xs-12">
                    <label><?=lang('full_name')?>: <?=mark_required()?></label>
                </div>
                <div class="col-xs-4">
                    <select name="title" class="form-control">
                        <option value="1" <?=set_select('title', '1')?>><?=lang('mr')?></option>
                        <option value="2" <?=set_select('title', '2')?>><?=lang('ms')?></option>
                    </select>
                </div>
                <div class="col-xs-8">
                    <input class="form-control" type="text" name="full_name" value="<?=set_value('full_name')?>" placeholder="<?=lang('field_what_full_name')?>"/>
                </div>

                <div class="col-xs-12"><?=form_error('full_name')?></div>
            </div>


            <div class="clearfix"></div>

            <div class="row clearfix">
                <div class="col-xs-12">
                    <label>
                        <?=lang('email_address')?>: <?=mark_required()?>
                    </label>
                </div>
                <div class="col-xs-12"><input class="form-control" placeholder="<?=lang('field_what_email')?>" type="text" name="email" value="<?=set_value('email')?>"/></div>
                <div class="col-xs-12"><?=form_error('email')?></div>
            </div>

            <div class="row no-padding">
                <div class="col-xs-6">
                    <label><?=lang('country')?>: <?=mark_required()?></label>
                    <select name="country" class="form-control no-padding">
                        <option value=""><?=lang('select_all')?></option>
                        <?php foreach ($countries as $key => $country) :?>
                            <option value="<?=$key?>" <?=set_select('country', $key)?>><?=$country[0]?></option>
                        <?php endforeach;?>
                    </select>
                    <?=form_error('country')?>
                </div>
                <div class="col-xs-6">
                    <label><?=lang('phone_number')?>: <?=mark_required()?></label>
                    <input class="form-control" type="text" name="phone" value="<?=set_value('phone')?>"/>
                    <?=form_error('phone')?>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="col-xs-12 no-padding"><?=note_required()?></div>
        </ol>

        <div class="col-xs-12 no-padding"><?=mark_required()?> &nbsp; <?=lang('spam_email_notify')?></div>

        <div class="clearfix"></div>
        <div class="margin-top-15">
            <button class="btn btn-green btn-lg col-xs-12" type="submit" name="action" value="submit" onclick="submit_request()">
                <?=lang('btn_sent_my_request')?> <span class="glyphicon glyphicon-circle-arrow-right"></span>
            </button>
        </div>
        <div class="clearfix"></div>
    </div>
</form>

<script>
    $(document).ready(function(){
        $( "#tour_duration" ).change(function() {
            calculate_tour_price();
        });

        calculate_tour_price();
    });

    function calculate_tour_price()
    {
        if ($('#tour_accommodation').length > 0 && $('#tour_duration').length > 0) {

            var duration = $('#tour_duration').val();
            <?php foreach ($tour_customize_class as $key=>$value):?>

            price_from = $("#price_from<?=$key?>").attr('price_from');
            $("#price_from<?=$key?>").text(duration * price_from);

            price_to = $("#price_to<?=$key?>").attr('price_to');
            $("#price_to<?=$key?>").text(duration * price_to);

            <?php endforeach;?>
        }
    }

</script>
