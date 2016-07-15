<form name="frm" method="post" id="frmRequest">
    <div class="bpt-contact">
        <div>
	        <div class="col-xs-2 avatar">
		        <?php if(!empty($schedule['avatar'])):?>
		            <img width="90px" height="90px" class="img-circle" src ="<?=base_url('images/users/'.$schedule['avatar'])?>"/>
		        <?php else:?>	        	
		            <img width="90px" height="90px" class="img-circle" src ="<?=base_url('media/team/hien-kim.jpg')?>"/>
		        <?php endif;?>
		    </div>
		    <div class="col-xs-10 content">
		        <div class="title"><?=strtoupper($schedule[0]['tailor_tour_title'])?></div>
			    <div><?=$schedule[0]['tailor_tour_description']?></div>
		    </div>
        </div>

        <ol>
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

            <div class="form-group people-group">

                <div class="col-xs-3">
                    <label for="adults" class="control-label col-xs-4"><?=lang('adults')?>:</label>
                    <div class="col-xs-8">
                        <select name="adults" class="form-control">
                            <?php for ($i = 1; $i <= ADULT_LIMIT; ++$i) :?>
                                <option value="<?=$i?>" <?=set_select('adults', $i, $i=='2'? true: false)?>><?=$i?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                </div>

                <div class="col-xs-4">
                    <label for="children" class="control-label col-xs-6"><?=lang('children')?>:</label>
                    <div class="col-xs-6">
                        <select name="children" class="form-control">
                            <?php for ($i = 0; $i <= CHILDREN_LIMIT; ++$i) :?>
                                <option value="<?=$i?>" <?=set_select('children', $i)?>><?=$i?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                </div>

                <div class="col-xs-4">
                    <label for="infants" class="control-label col-xs-5"><?=lang('infants')?>:</label>
                    <div class="col-xs-6">
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
            <div class="col-xs-12"><?=lang('field_tell_us_approximate_date')?></div>

            <div class="clearfix"></div>

            <div class="form-group" class="departure_date_customize" id="arrival">
                    <div class="col-xs-3">
                        <input class="form-control" type="text" class="departure_date_customize" name="departure_date_customize" id="departure_date_customize" placeholder="dd/mm/yyyy" value="<?=set_value('departure_date_customize')?>"/>
                    </div>
                    <div class="col-xs-12"><?=form_error('departure_date_customize')?></div>
            </div>

            <div class="clearfix"></div>

            <h3 class="text-highlight"><li><?=lang('field_tour_duration')?>:<?=mark_required()?></li></h3>

            <div class="form-group">
                <div class="col-xs-3">
                    <select name="tour_duration" class="form-control" id="tour_duration">
                        <option value=""><?=lang('label_please_select')?></option>
                        <?php for ($i = 1; $i <= 30; ++$i) :?>
                            <?php
                            $day_text = 'days';
                            if ($i == 1) $day_text = 'day';
                            ?>
                            <option value="<?=$i?>" <?=set_select('tour_duration', !empty($tour) ? $tour['duration'] : '', !empty($tour) && $tour['duration'] == $i)?>><?=$i. ' '.$day_text?></option>
                        <?php endfor;?>
                    </select>
                </div>
            </div>
            <div class="col-xs-12"><?=form_error('tour_duration')?></div>
            <div class="clearfix"></div>

            <h3 class="text-highlight"><li><?=lang('field_accomodation')?>:<?=mark_required()?></li></h3>

            <div class="form-group" id="tour_accommodation">
                    <?php foreach ($tour_customize_class as $key=>$value):?>
                        <div class="col-xs-3">
                            <label>
                                <input type="radio" name="tour_accommodation" value="<?=$key?>" <?=set_radio('tour_accommodation')?>>
                                <span><?=lang($value['name'])?></span>
                            </label>
                            <br>
                            <?php if (!empty($tour)):?>
	                            <?php if(empty($value['price_to'])):?>
	                                (>$<label id="price_from<?=$key?>" price_from="<?=$value['price_from']?>"><?=$value['price_from']?></label>)
	                            <?php else:?>
	                                ($<label id="price_from<?=$key?>" price_from="<?=$value['price_from']?>"><?=$value['price_from']?></label>- $<label id="price_to<?=$key?>" price_to="<?=$value['price_to']?>"><?=$value['price_to']?></label>)
	                            <?php endif;?>
                            <?php endif;?>
                        </div>
                    <?php endforeach;?>
            </div>

            <div class="col-xs-12"><?=form_error('tour_accommodation')?></div>
            <div class="clearfix"></div>


            <h3 class="text-highlight"><li><?=lang('field_what_ideal_trip')?></li></h3>
            <div><?=lang('field_tell_us_where_want_visit')?></div>
            <div class="clearfix"></div>

            <?php foreach ($parent_dess as $country):?>
                <div class="form-group col-xs-3">
                    <h4 class="pd-bottom-5"><?=$country['name']?></h4>
                    <?php foreach ($dess as $city):?>
                        <?php if($city['parent_id'] == $country['id']):?>
                            <label style="width: 100%; font-weight: normal"><input type="checkbox" value="<?=$city['name']?>" <?=set_checkbox('destination_visit', $city['name'])?> name="destination_visit[]">&nbsp;<?=$city['name']?></label>
                        <?php endif;?>
                    <?php endforeach;?>
                </div>
            <?php endforeach;?>

            <div class="clearfix"></div>

            <div class="form-group col-xs-10">
                <textarea class="form-control" name="message" cols="66" rows="5" placeholder="<?=lang('field_placehold_message')?>"><?=set_value('message')?></textarea>
                <?=form_error('message')?>
            </div>
            <div class="col-xs-2">
                <?=mark_required()?>
            </div>

            <div class="clearfix"></div>

            <h3 class="text-highlight"><li><?=lang('field_contact_details')?>:</li></h3>
            <div class="form-group">
                <div class="col-xs-6 row">
                    <div class="col-xs-12"><?=lang('full_name')?>: <?=mark_required()?></div>
                    <div class="col-xs-3">
                        <select name="title" class="form-control">
                            <option value="1" <?=set_select('title', '1')?>><?=lang('mr')?></option>
                            <option value="2" <?=set_select('title', '2')?>><?=lang('ms')?></option>
                        </select>
                    </div>
                    <div class="col-xs-9">
                        <input class="form-control" type="text" name="full_name" value="<?=set_value('full_name')?>" placeholder="<?=lang('field_what_full_name')?>"/>
                    </div>

                    <div class="col-xs-12"><?=form_error('full_name')?></div>

                    <div class="clearfix"></div>

                    <div class="col-xs-12"><?=lang('email_address')?>: <?=mark_required()?></div>
                    <div class="col-xs-12"><input class="form-control" placeholder="<?=lang('field_what_email')?>" type="text" name="email" value="<?=set_value('email')?>"/></div>
                    <div class="col-xs-12"><?=form_error('email')?></div>

                </div>

                <div class="col-xs-6 row">
                    <div class="col-xs-12"><?=lang('country')?>: <?=mark_required()?></div>
                    <div class="col-xs-12">
                        <select name="country" class="form-control">
                            <option value=""><?='-- ' . lang('select_country') .' --'?></option>
                            <?php foreach ($countries as $key => $country) :?>
                                <option value="<?=$key?>" <?=set_select('country', $key)?>><?=$country[0]?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="col-xs-12"><?=form_error('country')?></div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12"><?=lang('phone_number')?>: <?=mark_required()?></div>
                    <div class="col-xs-12"><input class="form-control" type="text" name="phone" placeholder="<?=lang('field_what_phone')?>" value="<?=set_value('phone')?>"/></div>
                    <div class="col-xs-12"><?=form_error('phone')?></div>
                </div>

            </div>
            <div class="clearfix"></div>
            <div class="col-xs-12"><?=note_required()?></div>
        </ol>
        <div class="clearfix"></div>

        <div class="col-xs-12"><?=mark_required()?> &nbsp; <?=lang('spam_email_notify')?></div>

        <div class="col-lg-offset-5 col-xs-2">
            <button class="btn btn-green btn-lg" type="submit" name="action" value="submit" onclick="submit_request()">
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
