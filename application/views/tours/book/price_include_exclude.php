<div class="bpv-box margin-top-20">
    <?php if(!empty($tour['service_includes']) || !empty($tour['service_excludes'])):?>
	<h2 class="bpv-color-title"><?=lang('service_policy')?></h2>
	<div class="col-xs-6">
	<h4 class="bpv-color-title"><?=lang('service_inclusion')?></h4>
		<?php if(!empty($tour['service_includes'])):?>
		
		<?php
			$includes = explode("\n", $tour['service_includes']);
			$includes = array_filter($includes, 'trim');
		?>
		<ul style="padding-left: 15px">
			<?php foreach ($includes as $item) :?>
			<?php if (!empty($item)) :?>
				<li class="margin-bottom-5"><?=$item?></li>
			<?php endif;?>			
			<?php endforeach;?>
		</ul>
		<?php endif;?>
	</div>
	<div class="col-xs-6">
	<h4 class="bpv-color-title"><?=lang('service_exclusion')?></h4>
		<?php if(!empty($tour['service_excludes'])):?>
		
		<?php
			$excludes = explode("\n", $tour['service_excludes']);
			$excludes = array_filter($excludes, 'trim');
		?>
		<ul style="padding-left: 15px">
			<?php foreach ($excludes as $item) :?>
			<?php if (!empty($item)) :?>
				<li class="margin-bottom-5"><?=$item?></li>
			<?php endif;?>			
			<?php endforeach;?>
		</ul>
		<?php endif;?>
	</div>
	<?php endif;?>
	
	<div class="col-xs-12">
	   <h4 class="bpv-color-title"><?=lang('children_policy_title')?></h4>
	   <table class="table table-bordered" style="width: auto;">
			<tr>
				<td class="td-1"><span class="icon icon-infant margin-right-5"></span><?=str_replace('<year>', $tour['infant_age_util'], lang('infant_policy_label'))?></td>
				<td class="td-2"><?=$tour['infants_policy']?></td>
			</tr>
			<tr>
				<td>
					<span class="icon icon-child margin-right-5"></span>
					<?php 
						$chd_txt = lang('children_policy_label');
						$chd_txt = str_replace('<from>', $tour['infant_age_util'], $chd_txt);
						$chd_txt = str_replace('<to>', $tour['children_age_to'], $chd_txt);
					?>
					<?=$chd_txt?>
				</td>
				<td><?=$tour['children_policy']?></td>
			</tr>
		</table>
	</div>
	
	<?php if(!empty($default_cancellation) || !empty($tour['extra_cancellation'])):?>
    <?php 
		$is_no_refund = $default_cancellation['id'] == CANCELLATION_NO_REFUND ? true : false;
	?>
    <div class="cancellation-box col-xs-12 margin-bottom-10">
        <h4 class="bpv-color-title"><?=lang('cancellation_policy')?></h4>
        <?=empty($tour['extra_cancellation']) || $is_no_refund ? $default_cancellation['content'] : $tour['extra_cancellation']?>
    </div>
    <?php endif;?>
</div>
