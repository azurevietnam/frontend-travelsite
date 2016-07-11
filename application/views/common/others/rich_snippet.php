<?php if(!empty($rich_snippet) && !empty($rich_snippet['review_score'])):?>
<div xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Review-aggregate">
   <meta property="v:itemreviewed" content="<?=$rich_snippet['title']?>"/>
   <span rel="v:rating">
      <span typeof="v:Rating">
      	<meta property="v:average" content="<?=($rich_snippet['review_score']*5)/10?>"/>	
      </span>
   </span>
   <meta property="v:count" content="<?=$rich_snippet['review_numb']?>" />
</div>
<?php endif;?>