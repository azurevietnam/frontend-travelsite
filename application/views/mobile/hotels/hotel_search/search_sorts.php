<ul class="nav nav-pills nav-stacked">
	<?php foreach ($sort_by as $key=>$value):?>
	
		<li <?php if($value['selected']):?>class="active"<?php endif;?>>
	    	<a href="javascript:void(0)" <?php if(!$value['selected']):?>onclick="sort_by('<?=$value['value']?>', '<?=site_url(HOTEL_SEARCH_PAGE)?>')"<?php endif;?>>
	    		<?=$value['label']?>
	    	</a>
	    	
	    	<?php if($value['selected']):?>
	    		<input type="hidden" value="<?=$value['value']?>" name="sort_by" id="sort_by_value">
	    		<i class="icon icon-ok"></i>
	    	<?php endif;?>
        </li>
		
	<?php endforeach;?> 
</ul>