<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div id="faq_categories">
	<h3 class="highlight"><?=lang('faq_categories')?><span
			class="arrow-down"></span>
	</h3>

	<ul>
	<?php foreach ($categories as $key => $category):?>
		<?php 
			$class = '';
			if($category_name == $category['name']) {
				$class = 'selected';
			}
			if($key == count($categories) - 1) $class .= ' no-border';
		?>
		<li <?php if(!empty($class)) echo 'class="'.$class.'"';?>><a
			href="<?=url_builder(FAQ_CATEGORY, $category['url_title'], true)?>"><?=$category['name']?></a>
			<span class="icon icon-s-arrow-left"></span></li>
	<?php endforeach;?>	
	</ul>

</div>