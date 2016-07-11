<?php if(!empty($related_question)):?>
    <div class="margin-top-20">
        <h3 style="font-size: 15px"><b><?=lang('related_questions')?></b></h3>
        <ul class="list-unstyled">
            <?php foreach($related_question as $value):?>
                <li class="margin-bottom-10">
                    <a href="<?=get_page_url(FAQ_DETAIL_PAGE, $value)?>"><?=$value['question']?></a>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
<?php endif;?>