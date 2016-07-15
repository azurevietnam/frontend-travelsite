<div class="fotorama margin-bottom-10" data-width="100%" data-ratio="16/9" data-max-width="100%" 
    data-nav="thumbs" data-allowfullscreen="true" data-loop="true"
    data-thumbwidth="64" data-thumbheight = "47" data-auto="false">
    <div class="loader"></div>
    <?php foreach ($photos as $photo):?>
        <img class="fotorama-img" alt="<?=$photo['caption']?>" src="<?=$photo['src']?>" data-caption="<?=$photo['caption']?>">
    <?php endforeach;?>
</div>

<script>
var slider_load = new Loader();
slider_load.require(<?=get_libary_asyn('fotorama')?>, 
function() {
    $('.fotorama').css('height', 'auto');
    $('.fotorama').fotorama();
});
</script>