<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Invoice System - Best Price Vietnam</title>
	<meta name="robots" content="noindex,nofollow" />			
	<link rel="shortcut icon" type="image/x-icon" href="<?=get_static_resources('/media/favicon.21082013.ico')?>"/>
	<?=get_static_resources('bootstrap.min.06052014.css', '/libs/bootstrap-3.1.1/css/');?>
	<?=get_static_resources('main.css,invoice.min.15052014.css');?>
	<?=get_static_resources('jquery-1.10.2.min.js', '/libs/');?>
</head>
<body>
	<div class="wraper1">
	
		<!-- banner -->
		<div class="banner1">
		    <div class="logo_bestpricevn">
		        <p><a href="#"><img width="212" height="54" src="<?=get_static_resources('/media/bestpricevn-logo.31052014.png')?>"></a></p>
		    </div>
		    <div class="logo_merchant">
		        <div style="padding-top: 40px; padding-left: 200px; text-align: right;">
		            <p/><div style="float: left; width: 110px;">Mã hoá đơn:</div>
		                <div style="float: left; width: 210px;text-align:left;padding-left:10px;"><?=$invoice['invoice_reference']?></div><br>
		            <div style="float: left; width: 110px;">Ngày lập:</div>
		                <div style="float: left; width: 210px;text-align:left;padding-left:10px;"><?=date('d/m/y', strtotime($invoice['date_created']))?></div>
		        </div>
		    </div>
		</div>
		
		<div class="content">
		
			<?php if(isset($VIEW_INVOICE) && $invoice['status'] == INVOICE_SUCCESSFUL):?>
			<h1 style="color:red;" class="payment_review">Hoá đơn thanh toán thành công!</h1>
			<?php elseif(in_array($invoice['customer_booking']['status'], array(BOOKING_CLOSE_LOST, BOOKING_CANCEL)) 
					|| $invoice['customer_booking']['deleted'] == DELETED):?>
			<h1 style="color:red;" class="payment_review">Hoá đơn thanh toán đã bị huỷ!</h1>
			<?php else:?>
			<h1 class="payment_review">Hoá đơn thanh toán</h1>
			<?php endif;?>
			
			<div class="payment_review">
			    <div class="row_payment_review">
			        <div style="font-weight:bold;" class="label_payment_review">
			            Công ty:
			        </div>
			        <div class="text_invoice_review">
			            <?=lang('company_name')?>
			        </div>
			    </div>
			    <div class="row_payment_review">
			        <div class="label_payment_review">
			            <?=lang('company_address_label')?>
			        </div>
			        <div class="text_invoice_review">
			            <?=lang('company_address')?>
			        </div>
			    </div>
			    <div class="row_payment_review">
			        <div class="label_payment_review" id="txtcustomerAdd">
			            Điện thoại:
			        </div>
			        <div class="text_invoice_review">
			            <?=PHONE_SUPPORT?>
			        </div>
			    </div>
			    <div class="row_payment_review">
			    	<div class="label_payment_review">
			            Hotline:
			        </div>
			        <div class="text_invoice_review">
			            <?=HOTLINE_SUPPORT?>
			        </div>
			    </div>
			    <div class="row_payment_review">
			        <div class="label_payment_review">
			            E-mail:
			        </div>
			        <div class="text_invoice_review">
			            <?=EMAIL_SUPPORT?>
			        </div>
			    </div>
			    <div class="row_payment_review">
			        <div class="label_payment_review">
			            Website:
			        </div>
			        <div class="text_invoice_review">
			            <?=site_url()?>
			        </div>
			    </div>
			</div>
			
			<div style="height:15px;font-weight: bold;margin-top:15px;" class="invoice_reference sub_text_title">Thông tin khách hàng</div>

			<div class="payment_review">
				<div class="row_payment_review">
					<div class="label_payment_review">Họ và tên:</div>
					<div class="text_invoice_review"><?=$invoice['customer']['full_name']?></div>
				</div>
				<div class="row_payment_review">
					<div class="label_payment_review">Địa chỉ:</div>
					<div class="text_invoice_review"><?=$invoice['customer']['city']?></div>
				</div>
				<div class="row_payment_review">
					<div class="label_payment_review">Điện thoại:</div>
					<div class="text_invoice_review"><?=$invoice['customer']['phone']?></div>
				</div>
				<div class="row_payment_review">
					<div class="label_payment_review">E-mail:</div>
					<div class="text_invoice_review"><?=$invoice['customer']['email']?></div>
				</div>
			</div>

			<div class="payment_review">
				<div id="txtstrAmount" class="label_payment_review">Tổng tiền:</div>
				<div style="color: black; font-weight: bold;"
					class="text_invoice_review"><?=number_format($invoice['amount'])?> <?=lang('vnd')?></div>
			</div>

			<div class="payment_review">
				<div class="row_payment_review">
					<div class="label_payment_review">Mô tả:</div>
					<div style="width: 470px;line-height:15px" class="text_invoice_review"><b>thanh toán cho:</b><br>
					
						<?=str_replace("\n", "<br>", $invoice['description'])?>
					</div>
				</div>
			</div>
			
			<div class="payment_review">
				<div class="row_payment_review">
					<div class="label_payment_review" style="color: #B20000;">Lưu ý:</div>
					<div style="width: 470px;" class="text_invoice_review">
						<ul style="color: #B20000; float: left; list-style: none; margin: 0; padding: 0;">
							<?php if($invoice_type == FLIGHT):?>
								<li><?=lang('flight_special_note')?></li>
							<?php endif;?>
						</ul>
					</div>
				</div>
			</div>
			
		    
		    <?php if(isset($VIEW_INVOICE) && ($invoice['status'] == INVOICE_NOT_PAID || $invoice['status'] == INVOICE_FAILED)):?>
		    
		    <?php if(in_array($invoice['customer_booking']['status'], array(BOOKING_NEW, BOOKING_PENDING))
		    		&& $invoice['customer_booking']['deleted'] != DELETED):?>
		    
		    <div style="font-weight: bold;margin:10px 0;" class="invoice_reference sub_text_title">
		        Điều khoản và điều kiện:
		    </div>
		    
		    <div style="clear: both;"></div>
		    <div class="term-condition">
				<ul style="margin: 0 0 0 10px; padding: 0; line-height: 20px;">
					<?php if($invoice_type == FLIGHT):?>
						<li><?=lang('flight_term_1')?></li>
						<li><?=lang('flight_term_2')?></li>
						
						<?php 
							$flights = $invoice['customer_booking']['service_reservations'];
						?>
						
						<?php foreach ($flights as $value):?>
							
							<?php if(!empty($value['fare_rules'])):?>
							<li style="border-bottom: 1px solid #DDD;margin-top:10px;color:#003580">
								<b>Điều khoản cho vé chuyến bay <?=$value['flight_code']?>, từ <?=$value['flight_from']?> đến <?=$value['flight_to']?>, <?=date(DATE_FORMAT_STANDARD, strtotime($value['start_date']))?>:</b>
							</li>
							
							<li style="padding-left:20px">							
								
								<?=$value['fare_rules']?>
								
							</li>
							<?php endif;?>
						<?php endforeach;?>
						
						
						
            		<?php endif;?>
				</ul>
            </div>
            
            <div class="bpv-box">
            	<?=$payment_method?>
            </div>
            
            <div class="repay-block">
	            <input type="checkbox" id="cbagree">
	            <a href="#">Tôi đồng ý với các điều khoản và điều kiện ở trên:</a>
	            <p style="margin: 20px 0 50px">
	            	<a href="javascript:repay()" type="button" class="btn btn-bpv btn-lg">
	            		<span class="glyphicon glyphicon-circle-arrow-right"></span>
						<?=lang('btn_pay')?>
					</a>
	            </p>
	        </div>
	        
	        <script>
				function repay(){
					var stcb = document.getElementById("cbagree");
		            if (stcb.checked == true) {
		            	var url = $('.bpv-payment-methods').find('.active').attr('paymenturl');
		            	var method = $('#payment_method').val();
						if (method != '') {
							window.document.location = url;
						} else {
							alert('Xin vui lòng chọn hình thức thanh toán!');	
						}
		            } else {
		                alert("Bạn phải đồng ý với các điều khoản ở trên trước khi thanh toán!");
		            }
			   	}
			</script>
			<?php endif;?>
			
	        <?php endif;?>
		</div>
	</div>
</body>
</html>
