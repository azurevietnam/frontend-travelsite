<div class="container">
    <?=$hotel_destinations?>
</div>

<script type="text/javascript">
    <?php if($is_ajax):?>
        get_hotel_price_from();
    <?php endif;?>
</script>