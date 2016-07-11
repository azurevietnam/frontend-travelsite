<?php 
	$is_price_per_cabin = is_price_per_cabin($tour);
	$nr_acc = count($accommodations);
?>

<?php foreach ($accommodations as $key => $value):?>
<div class="bpv-panel">
    <div class="panel-heading">
        <div class="panel-title bpv-toggle" data-target="#acc_<?=$value['id']?>">
            <div class="row">
                <div class="col-xs-10">
                    <h3 class="bpv-color-title"><?=$value['name']?></h3>
                    <?php if($is_price_per_cabin):?>
                        <?=lang('lbl_m2', $value['cabin_size'])?>, <?=$value['bed_size']?>
                    <?php endif;?>
                </div>
                <div class="col-xs-2 padding-left-0 text-right">
                    <span class="bpv-toggle-icon icon icon-chevron-down"></span>
                </div>
            </div>
        </div>
        <div id="acc_<?=$value['id']?>" class="bpv-toggle-content margin-top-10">
            <?php if(!empty($tour['cruise_id'])):?>
                <?php if(!empty($value['picture'])):?>
      				<img class="img-responsive" src="<?=get_image_path(PHOTO_FOLDER_CRUISE, $value['picture'], '468_351')?>">
      			<?php endif;?>
      			<div class="margin-top-10">
      				<?=$value['cabin_description']?>
      			</div>
      			
      			
                <button type="button" class="btn btn-default center-block margin-top-5" data-toggle="modal" data-target="#acc_info_<?=$value['id']?>">
                    <?=lang('view_facilities')?> <span class="icon icon-chevron-right"></span>			    
                </button>
                
                <?=$value['acc_info']?>
            <?php else:?>
                <?=insert_see_overview_link(generate_string_to_list($value['content']))?>
            <?php endif;?>
        </div>
    </div>
	<div class="panel-body">
	   <div class="text-center text-special">
	       <?=ucfirst(lang('label_enter_your_departure_date'))?>
	       <i class="glyphicon glyphicon-arrow-up"></i>
	   </div>
	</div>
</div>
<?php endforeach;?>

<script>
$('.bpv-toggle').bpvToggle(function(){
	var icon = $( '.bpv-toggle-icon', $( this ));
	if( $(icon).hasClass ('icon-chevron-down') ) {
		$(icon).toggleClass ('icon-chevron-up');
	}
});
</script>