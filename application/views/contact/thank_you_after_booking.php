<div class="bpt-col-right  pull-right">
	<div class="thank-you" style="background-color:#f5f5f5; padding: 20px;" >
		<h1 class="text-center title margin-top-20"  style="color: #693;"><?=lang('label_thank_booking')?></h1>
		
		<h2 class="text-center title" style="color: #693;"><?=lang("label_contact_you")?></h2>
		
		<div class="margin-left-20" style=" margin-top: 20px; font-size: 13px"><?=lang('spam_email_notify')?></div>
		
		<div class="margin-left-20" style="padding-top:10px;font-size: 13px"><?=lang('label_if_have_questions')?> <a href="mailto:sales@<?=strtolower(SITE_NAME)?>">sales@<?=strtolower(SITE_NAME)?></a>.</div>
			
		<div class="margin-left-20" style="padding-top:30px; text-align: left;">
			<span class="text-special glyphicon glyphicon-arrow-left"></span> &nbsp;<a style="font-size: 15px;" href="<?=site_url()?>"><?=lang('label_back_home_page')?></a>
		</div>
	</div>
</div>
<div class="bpt-col-left pull-left">
	<?=$tour_search_form?>
	<?=$tripadvisor?>
</div>


<?php if($is_from_thank_you_page) :?>

<!-- Google Code for thank-you Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1018666416;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "Pb24CKjVjgQQsLve5QM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1018666416/?value=0&amp;label=Pb24CKjVjgQQsLve5QM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<?php else:?>

<!-- Google Code for thank-you-request Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 1018666416;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "X8UlCKDWjgQQsLve5QM";
var google_conversion_value = 0;
/* ]]> */
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1018666416/?value=0&amp;label=X8UlCKDWjgQQsLve5QM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>


<?php endif;?>