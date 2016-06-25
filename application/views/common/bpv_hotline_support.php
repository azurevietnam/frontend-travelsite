<div class="hotline-support">
    <h3>
    	<span class="icon icon-hotline-support"></span><?=lang('support_hotline')?>
    </h3>
    <div class="support-box">
    	<?php if(isset($on_sidebar)):?>
    	
        	<?php foreach($hotline_users as $key=>$user):?>	
    				<div class="support-item<?php if(count($hotline_users) == 1) echo' no-border'?>" >
    		            <img class="img-circle" src="<?=get_image_path(USER_PHOTO, $user['avatar'], '90x90');?>" width="90" height="90">
    		            <ul>
    		                <li class="bpv-color-title"><?=$user['hotline_name']?></li>
    		                <li><b><?=$user['hotline_number']?></b></li>
    		                <li>Yahoo: <a href="ymsgr:sendim?<?=$user['yahoo_acc']?>"><span class="bpv-color-very-good"><?=$user['yahoo_acc']?></span></a></li>
    		                <li>Skype: <a href="skype:<?=$user['skype_acc']?>?chat"><span class="bpv-color-marketing"><?=$user['skype_acc']?></span></a></li>
    		            </ul>
    		        </div>
    		<?php endforeach;?>
    		
    	<?php else:?>
    	
    		<?php foreach($hotline_users as $key=>$user):?>
    		
    		<?php
    			$last_idx = count($hotline_users)%2 == 0 ? count($hotline_users) - 2 : count($hotline_users) - 1; 
    		?>
    		
    		<div class="<?=($key+1 == count($hotline_users) && $key%2 == 0) ? 'col-xs-12' : 'col-xs-6'?> no-padding">
    			<div class="support-item <?=$key <= 1 ? 'pd-top-0' : ''?> <?=$key >= $last_idx ? 'no-border pd-bottom-0' : ''?>">
    	            <img class="img-circle" src="<?=get_image_path(USER_PHOTO, $user['avatar'], '90x90');?>" width="90" height="90">
    	            <ul>
    	                <li class="bpv-color-title"><?=$user['hotline_name']?></li>
    	                <li><b><?=$user['hotline_number']?></b></li>
    	                <li>Yahoo: <a href="ymsgr:sendim?<?=$user['yahoo_acc']?>"><span class="bpv-color-very-good"><?=$user['yahoo_acc']?></span></a></li>
    	                <li>Skype: <a href="skype:<?=$user['skype_acc']?>?chat"><span class="bpv-color-marketing"><?=$user['skype_acc']?></span></a></li>
    	            </ul>
    	        </div>
    	    </div>
    
    		<?php endforeach;?>

    	<?php endif;?>
    	
    	<div class="working-times">
    		<?=lang('working_times_label')?>: <span class="bpv-color-title"><?=lang('working_times_content')?></span>
    	</div>
    </div>
</div>
