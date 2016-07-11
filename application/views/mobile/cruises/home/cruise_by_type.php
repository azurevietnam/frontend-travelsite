<?=!empty($rich_snippet) ? $rich_snippet : ''?>

<?php if(!empty($list_cruises)):?>
<div class="bpt-mb-list">
	<h2 class="text-highlight"><?=$recommended_title?></h2>
	<?=$list_cruises?>
</div>
<?php endif;?>

<?=!empty($cruise_categories) ? $cruise_categories : ''?>

<script type="text/javascript">
get_cruise_price_from();
</script>