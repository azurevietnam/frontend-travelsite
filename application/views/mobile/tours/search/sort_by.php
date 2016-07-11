<ul class="nav nav-pills nav-stacked">
    <?php foreach ($cnf_sort_by as $key => $value):?>
        <?php if($search_criteria['sort_by'] == $key):?>
        <li class="active">
            <a href="javascript:void(0)"><?=$value?></a> 
            <input type="hidden" value="popular" name="sort_by" id="sort_by_value"><i class="glyphicon glyphicon-ok"></i>
        </li>
        <?php else:?>
        <li>
            <a href="javascript:sort_by('<?=$key?>');"><?=$value?></a> 
            <input type="hidden" value="popular" name="sort_by" id="sort_by_value">
        </li>
        <?php endif;?>
    <?php endforeach;?>
</ul>