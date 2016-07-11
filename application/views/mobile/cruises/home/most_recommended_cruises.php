<div class="bpt-accordion">
    <h2 class="text-highlight"><?=$recommended_title?></h2>

    <div class="panel-group" id="cruise_accordion" role="tablist" aria-multiselectable="true">
        <?php foreach ($cruise_types as $key => $value):?>
            <?php if($value['show_tab']):?>
            
            <div class="panel panel-default">
        		<div class="panel-heading collapse-header" role="tab" id="heading_<?=$key?>">
        			<h4 class="panel-title" data-toggle="collapse" data-target="#collapse_<?=$key?>" aria-expanded="false" aria-controls="collapse_<?=$key?>">
        				<?=lang($value['label'])?>
        				<span class="glyphicon glyphicon-menu-right"></span>
        			</h4>
        		</div>
        		<div id="collapse_<?=$key?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_<?=$key?>">
        			<div class="panel-body no-padding">
        			<?=$value['list_cruises']?>
        			
        			<div class="container">
                        <a href="<?=site_url($value['type'])?>" class="btn btn-default btn-block btn-show-more">
                        <span class="glyphicon glyphicon-triangle-bottom"></span>
                        <?=lang($value['more_lang'])?>
                        </a>
                    </div>
        			</div>
        		</div>
        	</div>
            
            <?php endif;?>
        <?php endforeach;?>
    </div>
</div>

<script>
// fix bug on ios
$('.collapse-header').on('click', function () {
    $($(this).data('target')).collapse('toggle');
});

// change css class
$('#cruise_accordion').on('shown.bs.collapse', function (e) {
    $(e.target).prev('.panel-heading').find('.panel-title').addClass('active');
});

$('#cruise_accordion').on('hidden.bs.collapse', function (e) {
	$(e.target).prev('.panel-heading').find('.panel-title').removeClass('active');
});
</script>