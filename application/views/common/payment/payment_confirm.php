<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if($payment_status == INVOICE_SUCCESSFUL): ?>
<?=$breadcrumb?>
<?php endif;?>

<div class="box-gray">
        <?php if($payment_status == INVOICE_SUCCESSFUL): ?>
            <h1 class="text-choice"><?=lang('payment_page_header')?></h1>

            <p><?=lang('payment_page_desc')?></p>

            <?php if($invoice_type == VISA):?>
            	<h3><?=lang('payment_visa_header')?></h3>
            	<ol>
                    <li><?=lang('payment_visa_desc_1')?></li>
                    <li>
                        <?=lang('payment_visa_desc_2')?>
	                    <ul class="padding-left-20" style="list-style: disc;">
	                        <li><?=lang('payment_visa_note_1')?></li>
	                        <li><?=lang('payment_visa_note_2')?></li>
	                        <li><?=lang('payment_visa_note_3')?></li>
	                    </ul>
                    </li>
                    <li><?=lang('payment_visa_desc_3')?></li>
                </ol>
            <?php elseif($invoice_type == FLIGHT):?>
            	<h3><?=lang('payment_flight_header')?></h3>
	            <ul style="margin-left: 30px; list-style: disc;">
	                <li style="margin-bottom: 6px">
	                	<?=lang('payment_flight_desc_1')?>
	                </li>
	                <li><?=lang('payment_flight_desc_2')?></li>
	            </ul>
            <?php endif;?>
        <?php elseif($payment_status == INVOICE_PENDING):?>
            <h1 style="padding: 10px 0;" class="price"><?=lang('payment_pending_header')?></h1>
            <p><?=lang('payment_pending_desc_1')?></p>

            <p><?=lang('payment_pending_desc_2')?></p>
            <p><?=lang_arg('payment_contact', url_builder('',ABOUT_US . 'contact/'))?></p>
        <?php else :?>
            <h1 style=" padding: 10px 0;" class="price"><?=lang('payment_declined_header')?></h1>
            <p><?=lang('payment_declined_desc_1')?></p>

            <a href="<?=$pay_url?>">
                <span class="btn_general btn_submit_booking" style="width: 210px">
                    <?=lang('click_here_to_pay_again')?>
                </span>
            </a>

            <p><?=lang('payment_declined_desc_2')?></p>
            <ul style="margin-left: 30px; list-style: disc">
                <li><?=lang('payment_declined_reason_1')?></li>
                <li><?=lang('payment_declined_reason_2')?></li>
                <li><?=lang('payment_declined_reason_3')?></li>
            </ul>
            <p><?=lang_arg('payment_contact', url_builder('',ABOUT_US . 'contact/'))?></p>
        <?php endif?>
        <p><?=lang('thank_you')?></p>
        <p><?=BRANCH_NAME?></p>
</div>
    
<?php if($payment_status == "Success" && isset($recommendation_view)): ?>
<div class="recommend-on-success">
    <?=$recommendation_view?>
</div>
<?php endif;?>
