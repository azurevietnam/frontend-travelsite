<style>
.bpv-search{display:block}
</style>

<div class="container-fluid">
	<?=$bpv_ads?>
</div>

<div class="container">
	
	<?=$bpv_search?>
	
	<?=load_bpv_call_us(FLIGHT)?>

</div>

<?php if(!empty($lst_news)):?>
	
	<h2 class="bpv-color-promotion news-header"><?=lang('deal_messages')?></h2>
	
	<div class="container">
		<?php foreach ($lst_news as $news):?>
		<div class="news-content" onclick="go_url('<?=get_url(NEWS_DETAILS_PAGE, $news)?>')">
			
			<h4 class="bpv-color-title">
				<a href="<?=get_url(NEWS_DETAILS_PAGE, $news)?>"><?=$news['name']?></a>
			</h4>
			<p>
				<?=$news['short_description']?>
			</p>
							
		</div>
		<?php endforeach;?>	
	</div>
<?php endif;?>

