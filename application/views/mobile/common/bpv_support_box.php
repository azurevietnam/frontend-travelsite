<h3>
	<span class="icon icon-hotline-support"></span>
	<?=lang('support_hotline')?>
</h3>
<div class="support-box">
	<?php if(isset($is_side)):?>
		<div style="text-align: center;">
		<?php foreach ($hotline_users as $k => $user):?>
			<ul class="list-unstyled" style="border-bottom: 1px dashed #ccc; margin-bottom: 10px">
					<?php if($user['skype_acc'] != ''):?>
					<li>
						<a class="btn-skype" href="skype:<?=$user['skype_acc']?>?chat">
							<span class="left"></span>
							
							<?php if( is_working_time() ):?>
							<span class="icon skype"></span>
							<?php else:?>
							<span class="icon skype-offline"></span>
							<?php endif;?>
							
							<?=$user['hotline_name']?>
							<span class="right"></span>
						</a>
					</li>
					<?php endif;?>
					
					<?php if($user['yahoo_acc'] != ''):?>
					<li>
						<a class="btn-yahoo" href="ymsgr:sendim?<?=$user['yahoo_acc']?>">
							<span class="left"></span>
							
							<?php if( is_working_time() ):?>
							<span class="icon yahoo"></span>
							<?php else:?>
							<span class="icon yahoo-offline"></span>
							<?php endif;?>
							
							<?=$user['hotline_name']?>
							<span class="right"></span>
						</a>
					</li>
					<?php endif;?>
					
					<?php if($user['show_hotline']):?>
					<li class="hotline-number bpv-color-price">
						(<?=$user['hotline_number']?>)
					</li>
					<?php endif;?>
				</ul>
		<?php endforeach;?>
		</div>
	<?php else:?>
		<?php foreach ($hotline_users as $k => $user):?>
		
			<?php if(empty($user['skype_acc']) && empty($user['yahoo_acc'])) continue;?>
		
			<div class="col-xs-4" <?php if($k == count($hotline_users)-1) echo 'style="border:0"'?>>
				<ul class="list-unstyled">
					<?php if($user['skype_acc'] != ''):?>
					<li>
						<a class="btn-skype" href="skype:<?=$user['skype_acc']?>?chat">
							<span class="left"></span>
							
							<?php if( is_working_time() ):?>
							<span class="icon skype"></span>
							<?php else:?>
							<span class="icon skype-offline"></span>
							<?php endif;?>
							
							<?=$user['hotline_name']?>
							<span class="right"></span>
						</a>
					</li>
					<?php endif;?>
					
					<?php if($user['yahoo_acc'] != ''):?>
					<li>
						<a class="btn-yahoo" href="ymsgr:sendim?<?=$user['yahoo_acc']?>">
							<span class="left"></span>
							
							<?php if( is_working_time() ):?>
							<span class="icon yahoo"></span>
							<?php else:?>
							<span class="icon yahoo-offline"></span>
							<?php endif;?>
							
							<?=$user['hotline_name']?>
							<span class="right"></span>
						</a>
					</li>
					<?php endif;?>
					
					<?php if($user['show_hotline']):?>
					<li class="hotline-number bpv-color-price">
						(<?=$user['hotline_number']?>)
					</li>
					<?php endif;?>
				</ul>
	
				
			</div>		
		
		<?php endforeach;?>
	<?php endif;?>
	
	<div class="working-times">
		<?=lang('working_times_label')?>: <span class="bpv-color-title"><?=lang('working_times_content')?></span>
	</div>
</div>