<div class="bpt-contact">
	<h2 class="text-highlight">
		<?=$title?>
	</h2>
	<!--
	<div class="pull-right">
		<script language="javascript" type="text/javascript" src="//smarticon.geotrust.com/si.js"></script>
	</div>
	 -->

<?php if(!$without_form):?>
<form class="form-horizontal" method="post">
<?php endif;?>
  <input type="hidden" value="<?=ACTION_SUBMIT?>" name="cf_action">
	<div class="form-group">
		<div class="col-xs-12">
			<label for="full_name" class="control-label"><?=lang('full_name')?>: <?=mark_required()?></label>
		</div>
	  	<div>
		    <div class="col-xs-4">
		    	<select name="title" class="form-control">
					<option value="1" <?=set_select('title', '1')?>>Mr</option>
					<option value="2" <?=set_select('title', '2')?>>Ms</option>
				</select>
		    </div>
		    <div class="col-xs-8">
		      <input class="form-control" type="text" name="full_name" size="40" maxlength="50" value="<?=set_value('full_name')?>" tabindex="1"/>
		      <?=form_error('full_name')?>
		    </div>
	 	</div>
	</div>
	
 	<div class="form-group">
	 	<div class="col-xs-12">
		    <label for="email" class="control-label"><?=lang('email_address')?>: <?=mark_required()?></label>
	    </div>
	    <div class="col-xs-12">
	    	<input class="form-control" type="text" name="email" size="30" maxlength="50" value="<?=set_value('email')?>" tabindex="2"/>
	    	<?=form_error('email')?>
	    </div>
	</div>

  	<div class="form-group">
  		<div class="col-xs-12">
	    	<label for="email_cf" class="control-label"><?=lang('email_address_confirm')?>: <?=mark_required()?></label>
	    </div>
	    <div class="col-xs-12">
	    	<input class="form-control" type="text" name="email_cf" id="email_cf" size="30" maxlength="50" value="<?=set_value('email_cf')?>" tabindex="3" autocomplete="off"/>
	    	<?=form_error('email_cf')?>
	    </div>
 	</div>
 	
	<div class="form-group">
  		<div class="col-xs-12">
  			<label for="phone" class=" control-label"><?=lang('phone_number')?>: <?=mark_required()?></label>
  		</div>
	    <div class="col-xs-12">
	    	<input class="form-control" type="text" name="phone" size="30" maxlength="30" value="<?=set_value('phone')?>" tabindex="4"/>
	    	<?=form_error('phone')?>
	    </div>
  	</div>
   <!--
   <div class="form-group">
    <label for="phone" class="col-sm-2 control-label"><?=lang('fax_number')?>:</label>
    <div class="col-xs-6">
    	<input class="form-control" type="text" name="fax" size="30" maxlength="30" value="<?=set_value('fax')?>" tabindex="4"/>
    </div>
    <?=form_error('fax')?>
  </div>
   -->

   	<div class="form-group">
   		<div class="col-xs-12">
	    	<label for="country" class=" control-label"><?=lang('country')?>: <?=mark_required()?></label>
	    </div>
	    <div class="col-xs-10">
	    	 <select class="form-control" name="country" tabindex="6">
				<option value=""><?='-- ' . lang('select_country') .' --'?></option>
				<?php foreach ($countries as $key => $country) :?>
				<option value="<?=$key?>" <?=set_select('country', $key)?>><?=$country[0]?></option>
				<?php endforeach;?>
			</select>
			<?=form_error('country')?>
	    </div>
   </div>

   <div class="form-group">
   		<div class="col-xs-12">
   			<label for="city" class=" control-label"><?=lang('city')?>:</label>
   		</div>
	    <div class="col-xs-12">
	    	<input class="form-control" type="text" name="city" size="30" maxlength="100" value="<?=set_value('city')?>" tabindex="7"/>
	    </div>

   </div>

    <?php if(!empty($show_subject)):?>
        <div class="items">
            <label class="col-xs-2 control-label"><?=lang('subject')?>:</label>
            <div class="col-xs-10">
                <label class="col-xs-12"><input type="radio" name="subject" value="info" <?=set_radio('subject', 'info', true)?>/>&nbsp;<?=lang('ctu_information_on') ?>Information on <?=SITE_NAME?></label>
                <label class="col-xs-12"><input type="radio" name="subject" value="request" <?=set_radio('subject', 'request', $url == 'request'?true:false)?>/>&nbsp;<?=lang('ctu_special_request') ?></label>
                <label class="col-xs-12"><input type="radio" name="subject" value="claim" <?=set_radio('subject', 'claim', $url=='claim'?true:false)?>/>&nbsp;<?=lang('ctu_rate_guarantee_claim') ?></label>
                <label class="col-xs-12"><input type="radio" name="subject" value="feedback" <?=set_radio('subject', 'feedback', $url == 'feedback'?true:false)?>/>&nbsp;<?=lang('feedback') ?></label>
                <label class="col-xs-12"><input type="radio" name="subject" value="other" <?=set_radio('subject', 'other', $url == 'other'?true:false)?>/>&nbsp;<?=lang('other') ?></label>
            </div>
        </div>
    <?php endif;?>

  	<div class="form-group">
	  	<div class="col-xs-12">
	  		<label for="special_requests" class="control-label"><?=lang('special_requests')?>:</label>
	  	</div>	    
	    <div class="col-xs-12">
	    	<textarea class="form-control" name="special_requests" cols="66" rows="5" tabindex="8"><?=!empty($c_tour) ? set_value('special_requests', $c_tour) : set_value('special_requests')?></textarea>
	    </div>
  	</div>

  	<div class="form-group">
  		<div class="col-xs-12">
  			<?=note_required()?>
  		</div>
  	</div>
  	<div class="form-group">
	  	<div class="col-xs-12 text-info">
	    	<span style="color: red;">(*)</span> <?=lang('spam_email_notify')?>
	    </div>
  	</div>
  	<?php if(!$without_form):?>
  	<div class="form-group">
  		<div class="text-center col-xs-12">
  			<button type="submit" name="action" value="<?=ACTION_SUBMIT?>" class="btn btn-blue btn-lg btn-block"><?=lang('submit')?></button>
  		</div>
  	</div>

</form>
    <?php endif?>
</div>

<?php if(!$without_form):?>
<script type="text/javascript">

    <?php if(!empty($has_error)):?>
		go_position('.bpt-contact');
    <?php endif;?>

	function book(){
		document.frmMyBooking.action.value = "book";
		document.frmMyBooking.submit();
	}

	$(document).ready(function(){
	    $('#email_cf').bind("cut copy paste",function(e) {
	        e.preventDefault();
	    })
	});
</script>
<?php endif;?>