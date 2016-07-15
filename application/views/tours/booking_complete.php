<style>
	#searchForm {height: 320px}
</style>
<div id="contentLeft">
	<div id="searchForm">
		<?=$tour_search_view?>
	</div>
    
    <?=$why_use?>
</div>
<div id="contentMain">
	<div id="booking_complete" class="grayBox">
		<h1><?=lang('label_thank_booking')?></h1>
		<h2><?=lang("label_contact_you")?></h2>
		
		<div style="text-align: left; margin-top: 20px; font-size: 13px"><?=lang('spam_email_notify')?></div>
		
		<div style="text-align: left;padding-top:10px;font-size: 13px"><?=lang('label_if_have_questions')?> <a href="mailto:sales@<?=strtolower(SITE_NAME)?>">sales@<?=strtolower(SITE_NAME)?></a>.</div>
		
		
		<div style="padding-top:30px;text-align: left;">
			<span class="icon icon_arrow_left"></span><a style="font-size: 15px;" href="<?=site_url()?>"><?=lang('label_back_home_page')?></a>
		</div>
	</div>
</div>

<?php if($progress_tracker != '') :?>

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