<div class="search-form <?=!empty($css)? $css : ''?>" style="background-color: #fff; margin-top: -40px">
	<div class="nav bpt-tab-search">
		<ul class="nav nav-tabs" role="tablist">
		  <li role="presentation" class="active">
			  <a href="#search_tour_form" onclick="chang_search_type('search_tour_form')" aria-controls="search_tour_form" role="tab" data-toggle="tab"> 
			  	<span class="icon icon-tour-special margin-right-5" id="icon_tour_special"></span>
			  	<span class="icon icon-tour-white margin-right-5" id="icon_tour_white" style="display: none;"></span>
			  	<?=lang('search_type_tour')?>
			  </a>		  	
		  </li>

		  <!-- <li role="presentation">
		  	<a href="#search_flight_form" onclick="chang_search_type('search_flight_form')" aria-controls="search_flight_form" role="tab" data-toggle="tab">
		  		<span class="icon icon-flight-white margin-right-5" id="icon_flight_white"></span>
		  		<span class="icon icon-flight-special margin-right-5" id="icon_flight_special" style="display: none;"></span>
		  		<?=lang('search_type_flight')?>		  		
		  	</a>		  	
		  </li> -->
		  
		  <li role="presentation">
		  	<a href="#search_hotel_form" onclick="chang_search_type('search_hotel_form')" aria-controls="search_hotel_form" role="tab" data-toggle="tab">
			  	<span class="icon icon-hotel-white margin-right-5" id="icon_hotel_white"></span>  
			  	<span class="icon icon-hotel-special margin-right-5" id="icon_hotel_special" style="display: none;"></span> 
			  	<?=lang('search_type_hotel')?>
		  	</a>		  	
		  </li>
		</ul>
	</div>	
	<div class="tab-content search-tour-form searh-form-home">
	  <div role="tabpanel" class="tab-pane active" id="search_tour_form"><?=$tour_search_form?></div>
	  <div role="tabpanel" class="tab-pane" id="search_hotel_form"><?=$hotel_search_form?></div>
	  <!-- <div role="tabpanel" class="tab-pane" id="search_flight_form"><?=$search_form?></div> -->
	</div>
</div>

