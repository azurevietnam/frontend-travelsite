<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div style="padding: 10px; position: relative; width: 720px;">
	<h1 class="highlight" style="padding:0">
		<?php if($cruise['header_text'] != '') echo $cruise['header_text'];

			else {

				if ($cruise['cruise_destination'] == 1){

					echo $cruise['name'];
				} else {

					echo $cruise['name']. ' '.lang('halong_bay');
				}


			}

		?>

		<?php $star_infor = get_star_infor($cruise['star'], 1);?>
		<span class="icon <?=$star_infor['css_img']?>" title="<?=$star_infor['title']?>" alt="<?=$star_infor['title']?>"></span>

		<?php if($cruise['is_new'] == 1):?>
			<span class="special" style="font-weight: normal;">&nbsp;<?=lang('obj_new')?></span>
		<?php endif;?>

		<?=by_partner($cruise)?>
	</h1>


	<?php if($cruise['num_reviews'] > 0):?>
		<div class="bpt_item_review" style="position: absolute; right: 10px; top: 10px;">
			<div class="review_text"><span class="highlight"><b><?=review_score_lang($cruise['review_score'])?></b></span></div>
			<div>
				<b><span class="review_score"><?=$cruise['review_score']?></span></b> <span> of <?=$cruise['num_reviews']?> reviews</span>
			</div>
		</div>
	<?php endif;?>

	<div id="tabs">

		<ul>
			<li><a href="#cruise_photos_videos">Cruise Cabins & Photos-Videos</a></li>

			<li><a href="#cruise_properties">Facilities & Deckplan</a></li>

			<li><a href="#cruise_policies">Policies</a></li>

			<?php if(count($cruise['upload_files']) > 0):?>
			<li><a href="#cruise_resources">Resouces</a></li>
			<?php endif;?>
		</ul>

		<div id="cruise_photos_videos">

			<div id="cruise_detail" style="border: 0">

				<div class="main_image">
					<img alt="" src="<?=$this->config->item('cruise_220_165_path').$cruise['picture']?>"></img>
				</div>

				<?php if(isset($cruise['hot_deals']) && count($cruise['hot_deals']) > 0):?>

					<?php foreach ($cruise['hot_deals'] as $key=>$hot_deal):?>

					<div style="clear: right; margin-bottom: 5px;">

						<span class="special" style="font-size: 11px;"><img id="img_<?=$hot_deal['promotion_id']?>" alt="" src="/media/compare.gif" style="margin-bottom: -2px;"> <b><?=$hot_deal['name']?>:</b></span>
						<span>&nbsp;<a id="promotion_<?=$hot_deal['promotion_id']?>" class="link_function" style="font-size: 11px;" href="javascript:void(0)">detail</a></span>

						<script>

							var dg_content = '<?=get_promotion_condition_text($hot_deal)?>';
							var d_help = '<span class="special" style="font-size: 13px;"><?=htmlspecialchars($hot_deal['name'], ENT_QUOTES)?></span>';
							$("#promotion_<?=$hot_deal['promotion_id']?>").tiptip({fallback: dg_content, gravity: 's', title: d_help, width: '400px'});
						</script>
					</div>

					<?php endforeach;?>

				<?php endif;?>

				<?php
					$descriptions = str_replace("\n","<br>", $cruise['description']);
				?>
				<span><?=$descriptions?></span>
				<br>
				<span>Number of Cabins: <b><?=$cruise['num_cabin']?></b></span>
				<br>
				<div class="clearfix"></div>
				<?=$cruise_cabins?>
			</div>

			<p style="margin-bottom: 7px;"><span><?=lang('cruise_photos_description')?><b><?=$cruise['name']?></b>:</span></p>

			<div style="float: left;" id="cruise_photos">
				<?/*=$cruise_photos_view*/?>
			</div>

			<div style="float: left;" id="cruise_videos">
				<?/*=$videos_view*/?>
			</div>
		</div>


		<div id="cruise_properties">

			<p style="margin-top: 0; margin-bottom: 7px;"><?=lang('cruise_facility_description')?><b><?=$cruise['name']?></b>:</p>

			<h2 style="padding-left: 0; padding-top: 0" class="highlight" ><?=lang('facility_general')?></h2>

			<div class="facility">
					<ul>
						<?php foreach ($system_cruise_facilities[CRUISE_FACILITY_GENERAL] as $key => $value) :?>
								<?php if (array_key_exists($key, $cruise_facilities) && $cruise_facilities[$key] == 1) :?>
									<li style="float: left; width: 33%; margin-bottom: 5px;"><span class="icon icon_checkmark"></span><?=$value?></li>
								<?php else : ?>
								<?php endif ;?>

						<?php endforeach ;?>
					</ul>
			</div>

			<h2 style="padding-left: 0; padding-top: 0" class="highlight"><?=lang('facility_services')?></h2>
			<div class="facility">
					<ul>
						<?php foreach ($system_cruise_facilities[CRUISE_FACILITY_SERVICE] as $key => $value) :?>
								<?php if (array_key_exists($key, $cruise_facilities) && $cruise_facilities[$key] == 1) :?>
									<li style="float: left; width: 33%; margin-bottom: 5px;"><span class="icon icon_checkmark"></span><?=$value?></li>
								<?php else : ?>

								<?php endif ; ?>
						<?php endforeach ;?>

					</ul>
			</div>

			<h2 style="padding-left: 0; padding-top: 0" class="highlight"><?=lang('facility_activities')?></h2>
			<div class="facility">
					<ul>
						<?php foreach ($system_cruise_facilities[CRUISE_FACILITY_ACTIVITY] as $key => $value) :?>
								<?php if (array_key_exists($key, $cruise_facilities) && $cruise_facilities[$key] == 1) :?>
									<li style="float: left; width: 33%; margin-bottom: 5px;"><span class="icon icon_checkmark"></span><?=$value?></li>
								<?php else : ?>

								<?php endif ; ?>
						<?php endforeach ;?>
					</ul>
			</div>

			<div style="float: left; width: 100%;" id="cruise_properties_deckplans">
				<?/*=$properties_deckplans_view*/?>
			</div>
		</div>

		<div id="cruise_policies">

			<p style="margin-top: 0; margin-bottom: 7px;"><span><?=lang('cruise_policies_description')?><b><?=$cruise['name']?></b>:</span></p>

			<div class="policy" style="padding-top: 0;">
				<div class="policy_item highlight">
					<p>
						<?=lang('cruise_shuttle_bus')?>
					</p>
				</div>

				<div class="policy_content">
					<p><?=$cruise['shuttle_bus']?></p>
				</div>
			</div>


			<div class="policy">
				<div class="policy_item highlight">
					<p>
						<?=lang('cruise_check_in')?>
					</p>
				</div>

				<div class="policy_content">
					<p><?=$cruise['check_in']?></p>
				</div>
			</div>

			<div class="policy">
				<div class="policy_item highlight">
					<p>
						<?=lang('cruise_check_out')?>
					</p>
				</div>

				<div class="policy_content">
					<p><?=$cruise['check_out']?></p>
				</div>
			</div>

			<div class="policy">
				<div class="policy_item highlight">
					<p>
						<?=lang('cruise_guide')?>
					</p>
				</div>

				<div class="policy_content">
					<p><?=$cruise['guide']?></p>
				</div>
			</div>

			<?php if ($cruise['note'] != ''):?>

				<div class="policy">
					<div class="policy_item highlight">
						<p>
							<?=lang('cruise_other_notice')?>
						</p>
					</div>

					<div class="policy_content">
						<p><?=str_replace("\n", "<br>", $cruise['note'])?></p>
					</div>
				</div>
			<?php endif;?>

		</div>

		<?php if(count($cruise['upload_files']) > 0):?>
		<div id="cruise_resources">
				<p style="margin-top: 0; margin-bottom: 7px;">Cruise sources for <b>Download:</b></p>

				<ul style="width: 100%; float: left; padding-left: 10px;">
					<?php foreach ($cruise['upload_files'] as $file):?>

						<li style="float: left; width: 48%; margin-bottom: 10px;">
							<a href="/cruise_detail/download/<?=$file['name']?>" title="<?=$file['description']?>">
								<?php if($file['title'] != ''):?>
									<?=$file['title']?>
								<?php else:?>
									<?=$file['name']?>
								<?php endif;?>
							</a>
						</li>

					<?php endforeach;?>
				</ul>

		</div>
		<?php endif;?>
</div>


</div>

<script type="text/javascript">
	function init_tab(){
		$( "#tabs" ).tabs({
		});

	}

	function openCabinInfo(obj){

		var id = obj.id;

		var cabin_detail_id = "cabin_detail_" + id;

		var rowobj = document.getElementById(cabin_detail_id);

		if (obj.childNodes[0].className == 'togglelink'){

			obj.childNodes[0].className = 'togglelink_open';

			rowobj.style.display = '';

		} else {
			obj.childNodes[0].className = 'togglelink';

			rowobj.style.display = 'none';
		}

		return false;
	}

	function showVideo(video_id){

		var img_id = "#video_" + video_id + "_img";

		var content_id = "#video_" + video_id + "_content";

		var src = $(img_id).attr("src");

		//alert(src);

		if (src == "<?=site_url('media').'/btn_mini.gif'?>"){

			src = "<?=site_url('media').'/btn_mini_hover.gif'?>";

			$(img_id).attr("src", src);

			$(content_id).show();

		} else {

			src = "<?=site_url('media').'/btn_mini.gif'?>";

			$(img_id).attr("src", src);

			$(content_id).hide();
		}

	}

	function getImage(cruise_id){
		$.ajax({
			url: "<?=site_url('cruise_detail/get_image').'/'?>",
			type: "POST",
			cache: true,
			data: {
				"cruise_id": cruise_id,
				"cruise_url_title":"<?=$cruise['url_title']?>"
			},
			success:function(value){

				//alert(value);

				$("#cruise_photos").html(value);

			}
		});
	}

	function getImageList(cruise_id){
		$.ajax({
			url: "<?=site_url('cruise_detail/get_image_list').'/'?>",
			type: "POST",
			cache: true,
			data: {
				"cruise_id": cruise_id,
				"cruise_url_title":"<?=$cruise['url_title']?>"
			},
			success:function(value){

				$("#list_image").html(value);


			}
		});
	}

	function get_cruise_properties_deckplans(cruise_id, cruise_name){

		$.ajax({
			url: "<?=site_url('cruise_detail/get_cruise_properties_deckplans').'/'?>",
			type: "POST",
			cache: true,
			data: {
				"cruise_id": cruise_id,

				"cruise_name": cruise_name,

				"cruise_url_title":"<?=$cruise['url_title']?>"
			},
			success:function(value){

				//alert(value);

				$("#cruise_properties_deckplans").html(value);

			}
		});

	}

	function get_videos(cruise_id, cruise_name){
		$.ajax({
			url: "<?=site_url('cruise_detail/get_videos').'/'?>",
			type: "POST",
			cache: true,
			data: {
				"cruise_id": cruise_id,

				"cruise_name": cruise_name,

				"cruise_url_title":"<?=$cruise['url_title']?>"
			},
			success:function(value){

				$("#cruise_videos").html(value);

			}
		});
	}

	$(document).ready(function(){

		init_tab();

		getImageList("<?=$cruise['id']?>");

		getImage("<?=$cruise['id']?>");

		get_videos("<?=$cruise['id']?>", "<?=htmlentities($cruise['name'])?>");

		get_cruise_properties_deckplans("<?=$cruise['id']?>", "<?=htmlentities($cruise['name'])?>");

	});
</script>
