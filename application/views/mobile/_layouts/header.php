<div class="container bpv-header">
	<div class="row">
		<div class="col-xs-2">
			<button type="button" id="btn-menu-left">
		    	<span class="icon icon-menu"></span>
		    </button>
		</div>
		
		<div class="col-xs-8">
			 <a class="bpv-logo" href="<?=site_url()?>">
			    <img src="<?=get_static_resources('/media/mobile/bestprice-logo-m.05082014.png')?>" width="202" height="36">
			</a>
		</div>
		
		<div class="col-xs-2">
			<?php if( isset($meta) && $meta['search'] ):?>
		    	<button data-target=".bpv-search" id="btnIconSearch" type="button">
		    	   <span class="icon icon-search"></span>
		    	</button>
			<?php else:?>
			    <a id="hd_hotline_header" href="tel:<?=load_phone_support()?>"><span class="glyphicon glyphicon-earphone icon-phone-hd"></span></a>
			<?php endif;?>
		</div>
		
	</div>
</div>