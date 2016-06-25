	<div class="alert alert-warning alert-dismissable">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button">&times;</button>
      <span class="glyphicon glyphicon-warning-sign"></span>&nbsp;
      <strong><?=$message?></strong>
    </div>
    
    <ol style="font-weight:bold">
  		<li class="margin-bottom-10">
  			 <a href="<?=$link?>"><?=$link_label?></a>
  		</li>
  		<li>
  			<a href="javascript:void(0)" onclick="show_hide_contact(this)" show="show"><?=lang('contact_for_cheap_price')?></a>
  		</li>
	</ol>
	
	<div class="bpv-contact-container">
		<div class="content">
			<form method="post" role="form" action="<?=get_url(CONTACT_US_PAGE)?>">
				<?=$contact_form?>
			</form>
		</div>
	</div>