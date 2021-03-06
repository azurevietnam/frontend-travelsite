<div class="container">
	<h1 class="text-highlight"><?php echo lang('what_is_voa')?></h1>
    <?php if(isset($link_data)):?>
        <?php
        $answers = explode("\n", $link_data);
        ?>
    
        <?php foreach ($answers as $value) :?>
            <p><?=$value?></p>
        <?php endforeach;?>
    <?php endif;?>
    <p><?php echo lang('download_voa_and_sample')?></p>
	<div class="clearfix margin-top-10">
        <img width="16" height="16" src="<?=get_static_resources('/media/word.png')?>">
        <a href="/visa/visa_guides/download/form_apply.doc" style="font-weight: bold;"><?php echo lang('download_voa_form')?></a>
	</div>
	<div class="clearfix margin-top-10">
		<img width="16" height="16" src="<?=get_static_resources('/media/pdf.png')?>">
		<a href="/visa_guides/download/Vietnam_Immigration_Form.pdf" style="font-weight: bold;"><?php echo lang('download_vietnam_immigration_form')?></a>
	</div>
	<div class="clearfix margin-top-10">
		<img width="16" height="16" src="<?=get_static_resources('/media/pdf.png')?>">
		<a href="/visa_guides/download/Sample_Approval_Letter.pdf" style="font-weight: bold;"><?php echo lang('vietnam_approval_letter_sample')?></a>
	</div>
	<p class="margin-top-20">
		<b><?php echo lang('sample_of_voa_lettter')?>:</b>
		<img class="img-responsive" style="border: 1px solid #eee; margin-top: 5px" src="<?=get_static_resources('/media/vietnam_approval_letter_sample.jpg')?>">
	</p>
	<div class="related-info margin-top-20">
		<h3><?php echo lang('related_visa_information')?>:</h3>
        <?=$top_visa_questions?>
    </div>
</div>