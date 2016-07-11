<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?=lang('invoice_title_system')?></title>
	<meta name="robots" content="noindex,nofollow" />			
	<link rel="shortcut icon" type="image/x-icon" href="<?=get_static_resources('/media/favicon.21082013.ico')?>"/>
	<?=get_static_resources('invoice.min.05102013.css');?>
</head>
<body>
	<div class="wraper1">
	
		<!-- banner -->
		<div class="banner1">
		    <div class="logo_bestpricevn">
		        <p><a href="#"><img width="230" height="60" src="<?=get_static_resources('/media/logo.png')?>" alt="<?=lang('home_title')?>"></a></p>
		    </div>
		    <div class="logo_merchant">
		        <div style="font-size: 12px; padding-top: 40px; padding-left: 200px; text-align: right;">
		            <p/><div style="float: left; width: 110px;"><?=lang('payment_email_invoice_reference')?>:</div>
		                <div style="float: left; width: 210px;text-align:left;padding-left:10px;"><?=$invoice['invoice_reference']?></div><br>
		            <div style="float: left; width: 110px;"><?=lang('invoice_created_date')?>:</div>
		                <div style="float: left; width: 210px;text-align:left;padding-left:10px;"><?=date('d/m/y', strtotime($invoice['date_created']))?></div>
		        </div>
		    </div>
		</div>
		
		<div class="content">
		
			<?php if(isset($VIEW_INVOICE) && $invoice['status'] == INVOICE_SUCCESSFUL):?>
			<div style="color:red;text-align:center;font-size:16px;" class="payment_review"><?=lang('invoice_paid_successfully')?></div>
			<?php elseif(in_array($invoice['customer_booking']['status'], array(BOOKING_CLOSE_LOST, BOOKING_CANCEL)) 
					|| $invoice['customer_booking']['deleted'] == DELETED):?>
			<div style="color:red;text-align:center;font-size:16px;" class="payment_review"><?=lang('invoice_cancelled')?></div>
			<?php else:?>
			<div style="text-align:center;font-size:16px;" class="payment_review"><?=lang('Invoice')?></div>
			<?php endif;?>
			
			<div class="payment_review">
			    <div class="row_payment_review">
			        <div style="font-weight:bold;" class="label_payment_review">
			            <?=lang('invoice_merchant_name')?>:
			        </div>
			        <div class="text_invoice_review">
			            <?=lang('invoice_bpt_jsc')?>
			        </div>
			    </div>
			    <div class="row_payment_review">
			        <div class="label_payment_review">
			            <?=lang('invoice_merchant_address')?>:
			        </div>
			        <div class="text_invoice_review">
			            <?=lang('invoice_address')?>
			        </div>
			    </div>
			    <div class="row_payment_review">
			        <div class="label_payment_review" id="txtcustomerAdd">
			            <?=lang('invoice_tel')?>:
			        </div>
			        <div class="text_invoice_review">
			            (+84) 4 3624-9007
			        </div>
			        <div class="sub_label_payment_review">
			            <?=lang('invoice_fax')?>:
			        </div>
			        <div class="sub_text_invoice_review">
			            (+84) 4 3624-9007
			        </div>
			    </div>
			    <div class="row_payment_review">
			        <div class="label_payment_review">
			            <?=lang('invoice_email')?>:
			        </div>
			        <div class="text_invoice_review">
			            <?=SUBSCRIBE_EMAIL?>
			        </div>
			    </div>
			    <div class="row_payment_review">
			        <div class="label_payment_review">
			            <?=lang('invoice_website')?>:
			        </div>
			        <div class="text_invoice_review">
			            <?=lang('invoice_website_bestpricevn')?>
			        </div>
			    </div>
			</div>
			
			<div style="height:15px;font-size: 12px; font-weight: bold;margin-top:15px;" class="invoice_reference sub_text_title"><?=lang('invoice_customer_info')?></div>

			<div class="payment_review">
				<div class="row_payment_review">
					<div class="label_payment_review"><?=lang('payment_email_customer_name')?>:</div>
					<div class="text_invoice_review"><?=$invoice['customer']['full_name']?></div>
				</div>
				<div class="row_payment_review">
					<div class="label_payment_review"><?=lang('invoice_label_address')?>:</div>
					<div class="text_invoice_review"><?=$invoice['customer']['city']?></div>
					<div class="sub_label_payment_review"><?=lang('country')?>:</div>
					<div class="sub_text_invoice_review">
					<?php 
						foreach ($countries as $key => $country) {
							if($key == $invoice['customer']['country']) echo $country[0];
						}
					?>
					</div>
				</div>
				<div class="row_payment_review">
					<div class="label_payment_review"><?=lang('invoice_tel')?>:</div>
					<div class="text_invoice_review"><?=$invoice['customer']['phone']?></div>
					<div class="sub_label_payment_review"><?=lang('invoice_fax')?>:</div>
					<div class="sub_text_invoice_review"><?=$invoice['customer']['fax']?></div>
				</div>
				<div class="row_payment_review">
					<div class="label_payment_review"><?=lang('invoice_email')?>:</div>
					<div class="text_invoice_review"><?=$invoice['customer']['email']?></div>
				</div>
			</div>

			<div class="payment_review">
				<div id="txtstrAmount" class="label_payment_review"><?=lang('label_amount')?>:</div>
				<div style="color: black; font-weight: bold;"
					class="text_invoice_review">$<?=$invoice['amount']?></div>
			</div>

			<div class="payment_review">
				<div class="row_payment_review">
					<div class="label_payment_review"><?=lang('label_description')?>:</div>
					<div style="width: 470px;line-height:15px" class="text_invoice_review"><b><?=lang('invoice_pay_for')?>:</b><br>
					
						<?=str_replace("\n", "<br>", $invoice['description'])?>
					</div>
				</div>
				<div class="row_payment_review">
					<div class="label_payment_review"><?=lang('invoice_payment_method')?>:</div>
					<div style="width: 600px; color: black;"
						class="text_invoice_review"><?=lang('invoice_payment_online')?></div>
				</div>
				<div class="row_payment_review">
			        <div class="label_payment_review">
			            <?=lang('invoice_note')?>:
			        </div>
			        <div style="width:600px;color:black;" class="text_invoice_review">
			            <?=lang('invoice_must_agree')?>.
			        </div>
			    </div>
			</div>
			
			<div class="payment_review">
				<div class="row_payment_review">
					<div class="label_payment_review" style="color: #B20000;"><?=lang('important_notes')?>:</div>
					<div style="width: 470px;" class="text_invoice_review">
						<ul style="color: #B20000; float: left; list-style: none; margin: 0; padding: 0;">
							<?php if($invoice_type == VISA):?>
								<li><?=lang('visa_special_notes')?></li>
								<li><?=$receive_date?></li>
							<?php elseif($invoice_type == FLIGHT):?>
			 					<li><?=lang('flight_special_note')?></li>
							<?php endif;?>
						</ul>
					</div>
				</div>
			</div>
			
		    
		    <?php if(isset($VIEW_INVOICE) && ($invoice['status'] == INVOICE_NOT_PAID || $invoice['status'] == INVOICE_FAILED)):?>
		    
		    <?php if(in_array($invoice['customer_booking']['status'], array(BOOKING_NEW, BOOKING_PENDING))
		    		&& $invoice['customer_booking']['deleted'] != DELETED):?>
		    
		    <div style="font-size: 12px; font-weight: bold;margin:10px 0;" class="invoice_reference sub_text_title">
		       <?=lang('invoice_terms_conditions')?>:
		    </div>
		    
		    <div style="clear: both;"></div>
		    <div class="term-condition">
				<ul style="margin: 0 0 0 10px; padding: 0; line-height: 20px;">
					<?php if($invoice_type == VISA):?>
						<li><?=lang('visa_term_1')?></li>
						<li><?=lang('visa_term_2')?></li>
						<li><?=lang('visa_special_notes')?></li>
					<?php elseif($invoice_type == FLIGHT):?>
						<li><?=lang('flight_term_1')?></li>
						<li><?=lang('flight_term_2')?></li>
						
						<?php 
							$flights = $invoice['customer_booking']['service_reservations'];
						?>
						
						<?php foreach ($flights as $value):?>
							
							<?php if(!empty($value['fare_rules'])):?>
							<li style="border-bottom: 1px solid #DDD;margin-top:10px;color:#003580">
								<b><?=lang('flight_email_fare_rule_of_flight')?> <?=$value['flight_code']?>, <?=$value['flight_from']?> -&gt; <?=$value['flight_to']?>, <?=date(DATE_FORMAT_DISPLAY, strtotime($value['start_date']))?>:</b>
							</li>
							
							<li style="padding-left:20px">							
								
								<?=$value['fare_rules']?>
								
							</li>
							<?php endif;?>
						<?php endforeach;?>
						
						
						
            		<?php endif;?>
				</ul>
            </div>
            
            <form method="post" id="payment_form">
            <div class="repay-block">
    	            <input type="checkbox" id="cbagree"/>
    	            <a href="#"><?=lang('invoice_i_agree')?></a>
    	            <p style="margin: 10px 0 50px">
    	            	<a href="javascript:void(0)" onclick="repay()">
                		<img width="105" border="0" height="22" alt="" src="/media/button-checkout.jpg"/></a>
    	            </p>
    	            <input type="hidden" id="action" name="action" value=""/>
    	            <input type="hidden" name="invoice_reference" value="<?=$invoice['invoice_reference']?>"/>
	        </div>
	        </form>
	        
	        <script>
				function repay(){
					var stcb = document.getElementById("cbagree");
		            if (stcb.checked == true) {
		            	document.getElementById("action").value = "redirect";
		            	document.getElementById("payment_form").submit();
		            } else {
		                alert("<?=lang('invoice_must_agree')?>!");
		            }
			   	}
			</script>
			<?php endif;?>
			
	        <?php endif;?>
		</div>
	</div>
</body>
</html>
