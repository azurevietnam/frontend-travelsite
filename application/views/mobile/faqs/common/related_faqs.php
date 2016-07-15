<?php if(!empty($related_question)):?>
    <div class="panel panel-default margin-top-15">
        <div class="panel-heading"><?=lang('related_questions')?></div>

        <ul class="list-group">
            <?php foreach($related_question as $value):?>
                <li class="list-group-item">
                    <a href="<?=get_page_url(FAQ_DETAIL_PAGE, $value)?>"><?=$value['question']?></a>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
<?php endif;?>