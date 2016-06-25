<div id="tour_des_suggestion" class="hide">
    <h3 class="bpv-color-title">
        <span class="icon btn-support-close" onclick="$('#tour_destination').popover('hide');"></span>
    </h3>
    <div class="col-xs-6">
        <div class="bpv-tour-destination">
            <div class="bpv-color-title title">
            	<span class="icon icon-domestic-tour"></span> <?=lang('label_domestic_tours')?>
        </div>
        
        <?php foreach ($domestic_destinations as $k => $des):?>
            <div class="group-name" data-target="<?='#group_popup_'.$des['url_title']?>">
            <span class="icon <?=$k == 0 ? 'icon-arrow-right-sm icon-arrow-right-sm-down' : 'icon-arrow-right-sm'?> bpv-toggle-icon"></span>
            <?=$des['name']?>
            </div>
           
            <?php if(!empty($des['destinations'])):?>
            <div class="list-group" id="<?='group_popup_'.$des['url_title']?>" <?php if($k>0) echo'style="display:none"'?>>
            
                <a class="list-group-item item-enable sg-des" data-id="<?=$des['id']?>" data-name="<?=$des['name']?>">
                <?=lang('label_departing').$des['name']?>
                <span class="icon icon-arrow-right-b"></span>
                </a>
                   
                <?php foreach ($des['destinations'] as $highlight_des):?>
                <a class="list-group-item item-enable sg-des" data-id="<?=$highlight_des['id']?>" data-name="<?=$highlight_des['name']?>">
                <?=$highlight_des['name']?>
                <span class="icon icon-arrow-right-b"></span>
                </a>
                <?php endforeach;?>
            </div>
            <?php endif;?>
           
        <?php endforeach;?>
        
        </div>
    </div>
    <div class="col-xs-6">
        <div class="bpv-tour-destination">
            <div class="bpv-color-title title">
            	<span class="icon icon-outbound-tour"></span> <?=lang('label_outbound_tours')?>
            </div>
       
            <?php foreach ($outbound_destinations as $k => $des):?>
                <div class="group-name" data-target="<?='#group_popup_'.$des['url_title']?>">
                <span class="icon <?=$k == 0 ? 'icon-arrow-right-sm icon-arrow-right-sm-down' : 'icon-arrow-right-sm'?> bpv-toggle-icon"></span>
                <?=$des['name']?>
                </div>
               
                <?php if(!empty($des['destinations'])):?>
                <div class="list-group" id="<?='group_popup_'.$des['url_title']?>" <?php if($k>0) echo'style="display:none"'?>>
                
                    <a class="list-group-item item-enable sg-des" data-id="<?=$des['id']?>" data-name="<?=$des['name']?>">
                    <?=lang('label_departing').$des['name']?>
                    <span class="icon icon-arrow-right-b"></span>
                    </a>
                   
                    <?php foreach ($des['destinations'] as $highlight_des):?>
                    <a class="list-group-item item-enable sg-des" data-id="<?=$highlight_des['id']?>" data-name="<?=$highlight_des['name']?>">
                    <?=$highlight_des['name']?>
                    <span class="icon icon-arrow-right-b"></span>
                    </a>
                   <?php endforeach;?>
                </div>
                <?php endif;?>
               
            <?php endforeach;?>
           
    	</div>
    </div>
</div>