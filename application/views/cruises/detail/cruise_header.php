<div class="clearfix bp-header margin-bottom-10" xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Review-aggregate">
	<div class="col-license">
        <h1 class="text-highlight">
            <span property="v:itemreviewed"><?=$cruise['cruise_destination'] == HALONG_CRUISE_DESTINATION ? $cruise['name'] . ' ' . lang('halong_bay') : $cruise['name']?></span>
            <span class="icon <?=get_icon_star($cruise['star'], true)?>"></span>
            <?php if($cruise['is_new'] == 1):?>
                <span class="text-special"><?=lang('obj_new')?></span>
            <?php endif;?>
        </h1>
        <div class="col-info margin-bottom-5">
            <?=$cruise['address']?>
        </div>
        <div<?=!empty($review_page) ? ' class="hide"' : ''?>>
        <?=$review_overview?>
        </div>
        
        <?php if(!empty($review_page)):?>
        <div class="cruise-visa">
            <div class="pop-free-visa"><span class="icon icon-free-visa"></span><?=load_free_visa_popup($is_mobile)?></div>
        </div>
        <?php endif;?>
	</div>
	
    <div class="col-price">
        <div class="clearfix text-right cruise-ids" data-id="<?=$cruise['id']?>">
            <div class="price-tag">
                <?=ucfirst(lang('label_from'))?>:
                <span class="text-price"><?=lang('lbl_us')?>&nbsp;</span>
                <span class="price-origin c-origin-<?=$cruise['id']?>"></span>
                <span class="price-from c-from-<?=$cruise['id']?>" style="display:none"><?=lang('na')?></span>
                <?=lang('per_pax')?>
                <span class="price-tag-arrow"></span>
            </div>
     	
     	</div>
     	
     	<?php if(!empty($cruise['special_offers'])):?>
     	<div class="cruise-header-promotion">
     		<?=$cruise['special_offers']?>
     	</div>   
     	<?php endif;?>
     
        <div class="clearfix text-right margin-top-10">
            <?php if(!empty($review_page)):?>
            <a class="btn btn-green" href="<?=get_page_url($page, $cruise)?>"><?=lang('book_now')?></a>
            <?php else:?>
            <button class="btn btn-green" type="button" onclick="go_position('#cruise_rate')"><?=lang('book_now')?></button>
            <?php endif;?>
        </div>
    </div>
</div>