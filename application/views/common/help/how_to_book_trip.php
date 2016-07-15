<div class="bpt-left-block how-book-block">
	<h2 class="title text-highlight"><?=lang('how_to_book_a_trip')?></h2>

    <div class="step even"><span class="number">1</span><span data-title="<?=lang('step_1_title')?>" data-target='#how_book_step_1' data-placement='right' class="content"><?=lang('step_1')?><span class="glyphicon glyphicon-question-sign"></span></span></div>
    <div class="step"><span class="number">2</span><span data-title="<?=lang('step_2_title')?>" data-target='#how_book_step_2' data-placement='right' class="content"><?=lang('step_2')?><span class="glyphicon glyphicon-question-sign"></span></span></div>
    <div class="step even"><span class="number">3</span><span data-title="<?=lang('step_3_title')?>" data-target='#how_book_step_3' data-placement='right' class="content"><?=lang('step_3')?><span class="glyphicon glyphicon-question-sign"></span></span></div>
    <div class="step"><span class="number">4</span><span data-title="<?=lang('step_4_title')?>" data-target='#how_book_step_4' data-placement='right' class="content"><?=lang('step_4')?><span class="glyphicon glyphicon-question-sign"></span></span></div>
    <div class="step even"><span class="number">5</span><span data-title="<?=lang('step_5_title')?>" data-target='#how_book_step_5' data-placement='right' class="content"><?=lang('step_5')?><span class="glyphicon glyphicon-question-sign"></span></span></div>
    <div class="step text-right"><a href="<?=get_page_url(FAQ_DETAIL_PAGE, $faq_booking_process)?>"><?=lang('label_learn_more')?><span class="icon icon-double-arrow margin-bottom-5 margin-left-5"></span></a></div>
</div>

<div id='how_book_step_1' class="hidden">
	<?=lang('step_1_desc')?>
</div>
<div id='how_book_step_2' class="hidden">
    <?=lang('step_2_desc')?>
</div>
<div id='how_book_step_3' class="hidden">
    <?=lang('step_3_desc')?>
</div>
<div id='how_book_step_4' class="hidden">
    <?=lang('step_4_desc')?>
</div>
<div id='how_book_step_5' class="hidden">
    <?=lang('step_5_desc')?>
</div>


<script>
	set_help('.step .content');
</script>