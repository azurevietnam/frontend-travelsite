<ul class="sort-by">
	<li style="background-color:#FEBA02">
		<strong><?=lang('sort_by')?>:</strong>
	</li>
	
	<?php foreach ($cnf_sort_by as $key => $value):?>
		
		<?php if($search_criteria['sort_by'] == $key):?>
			<li class="selected">
				<span><?=$value?></span>
			</li>
		<?php else:?>
			<li>
				<a href="javascript:sort_by('<?=$key?>');"><?=$value?></a>
			</li>
		<?php endif;?>
	<?php endforeach;?>

</ul>
