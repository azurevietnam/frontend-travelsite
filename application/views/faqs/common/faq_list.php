
<div class="bpt-list">
    <?php if(!empty($list_categories)):?>
        <h1 class="text-highlight"><?=$list_categories['name']?></h1>
        <ol>
            <?php foreach($list_questions as $question) if($question['category_id']==$list_categories['id']):?>
                <a  class="faq-quest" id="q_<?=$question['id']?>" href="<?=get_page_url(FAQ_CATEGORY_PAGE, $list_categories)?>#q_<?=$question['id']?>" data-target="#faq_<?=$question['id']?>" data-icon="#icon_faq_question_<?=$question['id']?>" data-show="hide">
                    <li>
                        <?=$question['question']?>
                        <span class="glyphicon glyphicon-triangle-right text-special" id="icon_faq_question_<?=$question['id']?>" data-show="glyphicon-triangle-bottom" data-hide="glyphicon-triangle-right"></span>
                    </li>
                </a>
                    <div  id="faq_<?=$question['id']?>" class="faq-question margin-bottom-10" style="display:none">
                        <?=$question['answer']?>
                    </div>
            <?php endif; ?>
        </ol>

            <?php if(!empty($list_categories['sub_categories'])) foreach($list_categories['sub_categories'] as $value):?>
            <h2 class="text-highlight"><?=$value['name'] ?></h2>
                <ol>
                    <?php foreach($list_questions as $question) if($question['category_id']==$value['id']):?>
                        <a class="faq-quest" href="#faq_<?=$question['id']?>" data-target="#faq_<?=$question['id']?>" data-icon="#icon_faq_question_<?=$question['id']?>" data-show="hide">
                            <li>
                                <?=$question['question']?>
                                <span class="glyphicon glyphicon-triangle-right text-special" id="faq_<?=$question['id']?>" data-show="glyphicon-triangle-bottom" data-hide="glyphicon-triangle-right"></span>
                            </li>
                        </a>
                        <div id="faq_<?=$question['id']?>" class="faq-question" style="display:none">
                            <?=$question['answer']?>
                        </div>
                    <?php endif; ?>
                </ol>
            <?php endforeach;?>
    <?php elseif(!empty($list_questions)):?>
        <h1 class="text-highlight"><?=$destination['name'].' '.lang('label_faq')?></h1>
        <ol>
            <?php foreach($list_questions as $question):?>
                <a class="faq-quest" href="<?=get_page_url(FAQ_DESTINATION_PAGE, $destination)?>#faq_<?=$question['id']?>" data-target="#faq_<?=$question['id']?>" data-icon="#icon_faq_question_<?=$question['id']?>" data-show="hide">
                    <li>
                        <?=$question['question']?>
                        <span class="glyphicon glyphicon-triangle-right text-special" id="icon_faq_question_<?=$question['id']?>" data-show="glyphicon-triangle-bottom" data-hide="glyphicon-triangle-right"></span>
                    </li>
                </a>
                <div  id="faq_<?=$question['id']?>" class="faq-question" style="display:none;">
                    <?=$question['answer']?>
                </div>
            <?php endforeach;?>
        </ol>
    <?php endif;?>
</div>

<script>

    function open_question(){
        var hash = window.location.hash;
        if(hash != '' && hash != undefined){
          $(hash).click();
        }
    }

    set_show_hide('.faq-quest');
    open_question();

</script>