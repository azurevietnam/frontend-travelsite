<div class="container main-content">
	<ol class="breadcrumb">
	  <li><a href="<?=site_url()?>"><?=lang('mnu_home')?></a></li>
	  <li class="active"><?=lang('flights_text').' '.$airline['name']?></li>
	</ol>
		
	<div class="bpv-col-left margin-bottom-20">
		<?=$bpv_search?>
		<div class="margin-top-20">
			<a target="_blank" href="<?=site_url('tin-tuc/dat-kem-dich-vu-nhan-gia-uu-dai-10.html')?>">
				<img class="img-responsive" src="<?=get_static_resources('/media/flight/flights-deal.jpg')?>">
			</a>
		</div>
	</div>
	
	<div class="bpv-col-right margin-bottom-20">
	
		<div class="flight-content">
			<h1 class="bpv-color-title no-margin"><?=lang('flights_text').' '.$airline['name']?></h1>
			
			<div class="margin-top-10 margin-bottom-20">
				<?=$airline['description']?>
			</div>
		</div>
			
		<div class="flight-content-right">
			<?=load_hotline_suport(FLIGHT)?>
			
			<div class="bpv-box bpv-box-payment">
				<h3 class="bpv-color-title">
					<?=lang('payment_methods')?>
				</h3>
				<ul class="list-unstyled">
					<li><span class="icon icon-orange-dot"></span> <?=lang('payment_by_cash')?></li>
					<li><span class="icon icon-orange-dot"></span> <?=lang('payment_at_home')?></li>
					<li><span class="icon icon-orange-dot"></span> <?=lang('payment_by_bank_transfer')?></li>
					<li><span class="icon icon-orange-dot"></span> <?=lang('payment_by_credit_card')?></li>
					<li><span class="icon icon-orange-dot"></span> <?=lang('payment_by_domestic_card')?></li>
				</ul>
			</div>
		</div>
	</div>
	
	<?=$search_dialog?>
	
	<?=$footer_links?>
</div>

<?=$bpv_register?>