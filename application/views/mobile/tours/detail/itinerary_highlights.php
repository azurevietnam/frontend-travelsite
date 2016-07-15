<?php if(!empty($highlights)):?>
    <h2 class="text-highlight container"><b><?=lang('trip_highlights')?></b></h2>
    <div class="bpt-accordion trip-highlights">
        <div class="panel-group" id="it_accordion" role="tablist" aria-multiselectable="true">
        <?php foreach ($highlights as $k => $value):?>
        <div class="panel panel-default">
    		<div class="panel-heading collapse-header" role="tab" id="it_heading_<?=$k?>">
    			<h4 class="panel-title text-link" data-toggle="collapse" data-target="#it_collapse_<?=$k?>" aria-expanded="false" aria-controls="it_collapse_<?=$k?>">
    				<b><?=$value['label']?>:</b> <?=$value['title']?>
    				<span class="glyphicon glyphicon-menu-right"></span>
    			</h4>
    		</div>
    		<div id="it_collapse_<?=$k?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="it_heading_<?=$k?>">
    			<div class="panel-body">
    			<?php if(!empty($value['content'])):?>
                <?php $tour_highlights = explode("\n", $value['content']);?>
                <ul class="clearfix padding-left-20">
                    <?php foreach ($tour_highlights as $hl_value):?>
            			<?php if(!empty($hl_value)):?>
            			<li class="margin-bottom-5"><span><?=format_object_overview($hl_value)?></span></li>
            			<?php endif;?>
            		<?php endforeach;?>
                </ul>
                <?php endif;?>
    			</div>
    		</div>
    	</div>
        <?php endforeach;?>
        </div>
    </div>
    
    <script>
    // fix bug on ios
    $('.collapse-header').on('click', function () {
        $($(this).data('target')).collapse('toggle');
    });
    
    // change css class
    $('#it_accordion').on('shown.bs.collapse', function (e) {
        $(e.target).prev('.panel-heading').find('.panel-title').addClass('active');
    });
    
    $('#it_accordion').on('hidden.bs.collapse', function (e) {
    	$(e.target).prev('.panel-heading').find('.panel-title').removeClass('active');
    });
    </script>

<?php else:?>
    <div class="container">
        <h3 class="text-highlight"><?=lang('trip_highlights')?></h3>
    
        <?php $tour_highlights = explode("\n", $tour['tour_highlight']);?>
    
        <?php if(!empty($tour_highlights)):?>
    	<ul class="tour-highlight clearfix">
    		<?php foreach ($tour_highlights as $value):?>
    			<?php if(!empty($value)):?>
    			<li class="margin-bottom-10"><span class="icon icon-check"></span><?=format_object_overview($value)?></li>
    			<?php endif;?>
    		<?php endforeach;?>
    	</ul>
        <?php endif;?>
    </div>
<?php endif;?>