<?php if(!empty($list_categories)):?>
    <h1 class="text-highlight"><?=$list_categories['name']?></h1>
    <?php foreach($list_questions as $question) if($question['category_id']==$list_categories['id']):?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="<?=get_page_url(FAQ_CATEGORY_PAGE, $list_categories)?>#q_<?=$question['id']?>" aria-expanded="true" aria-controls="collapseOne">
                            <?=$question['question']?>
                        </a>
                    </h4>
                </div>
                <div id="q_<?=$question['id']?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <?=$question['answer']?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif;?>

<?php if(!empty($list_categories['sub_categories'])) foreach($list_categories['sub_categories'] as $value):?>
    <h2 class="text-highlight"><?=$value['name'] ?></h2>

    <?php foreach($list_questions as $question) if($question['category_id']==$value['id']):?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="<?=get_page_url(FAQ_CATEGORY_PAGE, $list_categories)?>#q_<?=$question['id']?>" aria-expanded="true" aria-controls="collapseOne">
                            <?=$question['question']?>
                        </a>
                    </h4>
                </div>
                <div id="q_<?=$question['id']?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <?=$question['answer']?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>
<?php endforeach;?>

<script>
    function open_question(){
        var hash = window.location.hash;
        if(hash != '' && hash != undefined){
            $(hash).click();
        }
    }

    open_question();
</script>