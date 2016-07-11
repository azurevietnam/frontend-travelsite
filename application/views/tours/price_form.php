<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!-- Price Form -->
<div id="priceForm">
	<div id="priceFormContent">
    <h2 class="highlight"><?=$price_params['form_title']?></h2>
    <?php if(isset($tour)) :?>
    <div class="row">
    	<span class="label"><?=ucfirst('tour')?>:&nbsp;</span>
        <span class="highlight"><?=$tour['name']?></span>
    </div>
    <?php endif;?>
    <div class="row">    	            
        <span class="label"><?=lang('class_accomm')?>:&nbsp;</span>
        <select name="class_service" id="class_service">
			<?php foreach ($c_services as $c_service) :?>
                <option value="<?=$c_service?>" <?=set_select('class_service', $c_service, $c_service == $price_params['c_service']?TRUE:FALSE)?>><?=lang($config_services[$c_service])?></option>
			<?php endforeach;?>
        </select>
    </div>        
    <div class="row">
    	<span style="display:block" class="label">Guests:</span>
        <div class="box">
            <span style="display:block">Adults:</span>
            <span style="visibility:hidden">Adults:</span>
            <span style="display:block">
                <select name="adults" id="adults">
					<?php for ($i = 1; $i <= ADULT_LIMIT; ++$i) :?>
                    <option value="<?=$i?>" <?=set_select('adults', $i, $i == $price_params['guests'][0]?TRUE:FALSE)?>><?=$i?></option>
                    <?php endfor;?>
                </select>
            </span>
        </div>
        <div class="box">
            <span style="display:block">Children (5-10):</span>
            <span style="display:block">
                <select name="children" id="children">
					<?php for ($i = 0; $i <= CHILDREN_LIMIT; ++$i) :?>
                    <option value="<?=$i?>" <?=set_select('children', $i, $i == $price_params['guests'][1]?TRUE:FALSE)?>><?=$i?></option>
                    <?php endfor;?>
                </select>
            </span>
        </div>
        <div class="box">
            <span style="display:block">Infants (0-4):</span>
            <span style="display:block">
                <select name="infants" id="infants">
					<?php for ($i = 0; $i <= CHILDREN_LIMIT; ++$i) :?>
                    <option value="<?=$i?>" <?=set_select('infants', $i, $i == $price_params['guests'][2]?TRUE:FALSE)?>><?=$i?></option>
                    <?php endfor;?>
                </select>
            </span>
        </div>                        
    </div>	  
    <div class="row">            
        <span style="display:block" class="label"><?=lang('departure_date')?>:</span>            
        <div id="date_picker">
            <select name="departure_day" id="departure_day" onchange="changeDay('tour')">
            <option value=""><?=date('D, Y')?></option>
            </select>            
            &nbsp;
            <select name="departure_month" id="departure_month" onchange="changeMonth('tour')">
            <option value=""><?=date('M, Y')?></option>                  
            </select>                
            &nbsp;<input type="hidden" id="departure_date" name="departure_date"/>
        </div>
    </div>
    <div class="row">
        <span style="float:right"><input class="button" type="button" value="<?=$price_params['button_label']?>" onclick="showPrice();"/></span>
    </div>
    </div>
</div><!-- End Price Form -->
<script>
$(document).ready(function(){	
	//var this_date = '<?=date('d-m-Y')?>';
	//var current_date = '<?=date('d-m-Y', strtotime($price_params['depart_date']))?>';

	<?php $resource_path = $this->config->item('resource_path');?>

	$("#tour_tabs").tabs({ cache: true, spinner:'Loading...',selected:<?=$price_params['tab_selected']?>, ajaxOption:{cache:true},
			load: function(event, ui) {
				// only process for customer review
				//alert($('#tour_tabs').tabs('option','selected'));
				if ($('#tour_tabs').tabs('option','selected') == 4){
		
			        $('a', ui.panel).click(function() {				      
	
			        	$('#tour_tabs').tabs("url", $('#tour_tabs').tabs('option',
			        	'selected'), this.href).tabs("load",$('#tour_tabs').tabs('option',
			        	'selected')); 
			            return false;
			        });
	
					}
		        
    			}
			
			});
	//initDate(this_date, current_date, 'tour');
	
});
function showPrice(){
	document.forms[0].action_type.value = "calculate";
	document.forms[0].submit();		
}
function collapse(){
	if ($("#priceFormContent").css("display") == "none") {
		$("#priceFormContent").css("display", "");
		$("#contentLeft").css("width", "230px");
		$("#contentMain").css("width", "750px");				
		$("#wrap").css("width", "600px");
	} else {
		$("#priceFormContent").css("display", "none");
		$("#contentLeft").css("width", "5px");
		$("#contentMain").css("width", "975px");
		$("#wrap").css("width", "825px");
				
	}
}
</script>