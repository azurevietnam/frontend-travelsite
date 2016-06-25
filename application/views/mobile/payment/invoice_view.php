<div class="container">
    <?php if(isset($VIEW_INVOICE) && $invoice['status'] == INVOICE_SUCCESSFUL):?>
    <h1 style="color:red;" class="invoice-title">Hoá đơn thanh toán thành công!</h1>
    <?php elseif(in_array($invoice['customer_booking']['status'], array(BOOKING_CLOSE_LOST, BOOKING_CANCEL)) 
    		|| $invoice['customer_booking']['deleted'] == DELETED):?>
    <h1 style="color:red;" class="invoice-title">Hoá đơn thanh toán đã bị huỷ!</h1>
    <?php else:?>
    <h1 class="invoice-title">Hoá đơn thanh toán</h1>
    <?php endif;?>
    
    <div class="row">
        <div class="col-xs-4">Mã hoá đơn:</div>
        <div class="col-xs-8"><?=$invoice['invoice_reference']?></div>
    </div>
    <div class="row">
        <div class="col-xs-4">Ngày lập:</div>
        <div class="col-xs-8"><?=date('d/m/y', strtotime($invoice['date_created']))?></div>
    </div>
    
    <h3 class="bpv-color-title">Thông tin công ty</h3>
    <div class="row">
        <div class="col-xs-4">Công ty:</div>
        <div class="col-xs-8"><?=lang('company_name')?></div>
    </div>
    <div class="row">
        <div class="col-xs-4"><?=lang('company_address_label')?></div>
        <div class="col-xs-8"><?=lang('company_address')?></div>
    </div>
    <div class="row">
        <div class="col-xs-4">Điện thoại:</div>
        <div class="col-xs-8"><?=PHONE_SUPPORT?></div>
    </div>
    <div class="row">
        <div class="col-xs-4">Hotline:</div>
        <div class="col-xs-8"><?=HOTLINE_SUPPORT?></div>
    </div>
    <div class="row">
        <div class="col-xs-4">E-mail:</div>
        <div class="col-xs-8"><?=EMAIL_SUPPORT?></div>
    </div>
    <div class="row">
        <div class="col-xs-4">Website:</div>
        <div class="col-xs-8"><?=site_url()?></div>
    </div>
    
    <h3 class="bpv-color-title">Thông tin khách hàng</h3>
    <div class="row">
        <div class="col-xs-4">Họ và tên:</div>
        <div class="col-xs-8"><?=$invoice['customer']['full_name']?></div>
    </div>
    <div class="row">
        <div class="col-xs-4">Địa chỉ:</div>
        <div class="col-xs-8"><?=$invoice['customer']['city']?></div>
    </div>
    <div class="row">
        <div class="col-xs-4">Điện thoại:</div>
        <div class="col-xs-8"><?=$invoice['customer']['phone']?></div>
    </div>
    <div class="row">
        <div class="col-xs-4">E-mail:</div>
        <div class="col-xs-8"><?=$invoice['customer']['email']?></div>
    </div>
    
    
    <div class="row">
        <div class="col-xs-4">Tổng tiền:</div>
        <div class="col-xs-8"><b><?=number_format($invoice['amount'])?> <?=lang('vnd')?></b></div>
    </div>
    <div class="row">
        <div class="col-xs-4">Mô tả:</div>
        <div class="col-xs-8">
            <b>thanh toán cho:</b>
            <?=str_replace("\n", "<br>", $invoice['description'])?>
        </div>
    </div>
    
    <?php if($invoice_type == FLIGHT):?>
    <div class="row">
        <div class="col-xs-4 bpv-color-warning">Lưu ý:</div>
        <div class="col-xs-8 bpv-color-warning"><?=lang('flight_special_note')?></div>
    </div>
    <?php endif;?>
    
    <?php if(isset($VIEW_INVOICE) && ($invoice['status'] == INVOICE_NOT_PAID || $invoice['status'] == INVOICE_FAILED)):?>
		    
    <?php if(in_array($invoice['customer_booking']['status'], array(BOOKING_NEW, BOOKING_PENDING))
    		&& $invoice['customer_booking']['deleted'] != DELETED):?>
    
    <p><b>Điều khoản và điều kiện:</b></p>
    
    <div style="clear: both;"></div>
    <div class="term-condition">
		<ul style="margin: 0; padding: 0;">
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
    
    <?=$payment_method?>
    
    <div class="repay-block">
        
        <input type="checkbox" id="cbagree">
        <label for="cbagree" style="font-weight: normal; display: inline;">Tôi đồng ý với các điều khoản và điều kiện ở trên.</label>
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
