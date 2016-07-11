<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if(count($tour_hot_deals) > 0):?>
<!-- 
<script type="text/javascript" src="/js/jcarousellite/jcarousellite_1.0.1.min.js"></script>
<script type="text/javascript" src="/js/jcarousellite/jquery.easing.1.1.min.js"></script>
 -->
 
 <script type="text/javascript">
 jQuery.easing={easein:function(x,t,b,c,d){return c*(t/=d)*t+b},easeinout:function(x,t,b,c,d){if(t<d/2){return 2*c*t*t/(d*d)+b}var ts=t-d/2;return -2*c*ts*ts/(d*d)+2*c*ts/d+c/2+b},easeout:function(x,t,b,c,d){return -c*t*t/(d*d)+2*c*t/d+b},expoin:function(x,t,b,c,d){var flip=1;if(c<0){flip*=-1;c*=-1}return flip*(Math.exp(Math.log(c)/d*t))+b},expoout:function(x,t,b,c,d){var flip=1;if(c<0){flip*=-1;c*=-1}return flip*(-Math.exp(-Math.log(c)/d*(t-d))+c+1)+b},expoinout:function(x,t,b,c,d){var flip=1;if(c<0){flip*=-1;c*=-1}if(t<d/2){return flip*(Math.exp(Math.log(c/2)/(d/2)*t))+b}return flip*(-Math.exp(-2*Math.log(c/2)/d*(t-d))+c+1)+b},bouncein:function(x,t,b,c,d){return c-jQuery.easing.bounceout(x,d-t,0,c,d)+b},bounceout:function(x,t,b,c,d){if((t/=d)<(1/2.75)){return c*(7.5625*t*t)+b}else{if(t<(2/2.75)){return c*(7.5625*(t-=(1.5/2.75))*t+0.75)+b}else{if(t<(2.5/2.75)){return c*(7.5625*(t-=(2.25/2.75))*t+0.9375)+b}else{return c*(7.5625*(t-=(2.625/2.75))*t+0.984375)+b}}}},bounceinout:function(x,t,b,c,d){if(t<d/2){return jQuery.easing.bouncein(x,t*2,0,c,d)*0.5+b}return jQuery.easing.bounceout(x,t*2-d,0,c,d)*0.5+c*0.5+b},elasin:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0){return b}if((t/=d)==1){return b+c}if(!p){p=d*0.3}if(a<Math.abs(c)){a=c;var s=p/4}else{var s=p/(2*Math.PI)*Math.asin(c/a)}return -(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b},elasout:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0){return b}if((t/=d)==1){return b+c}if(!p){p=d*0.3}if(a<Math.abs(c)){a=c;var s=p/4}else{var s=p/(2*Math.PI)*Math.asin(c/a)}return a*Math.pow(2,-10*t)*Math.sin((t*d-s)*(2*Math.PI)/p)+c+b},elasinout:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0){return b}if((t/=d/2)==2){return b+c}if(!p){p=d*(0.3*1.5)}if(a<Math.abs(c)){a=c;var s=p/4}else{var s=p/(2*Math.PI)*Math.asin(c/a)}if(t<1){return -0.5*(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b}return a*Math.pow(2,-10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p)*0.5+c+b},backin:function(x,t,b,c,d){var s=1.70158;return c*(t/=d)*t*((s+1)*t-s)+b},backout:function(x,t,b,c,d){var s=1.70158;return c*((t=t/d-1)*t*((s+1)*t+s)+1)+b},backinout:function(x,t,b,c,d){var s=1.70158;if((t/=d/2)<1){return c/2*(t*t*(((s*=(1.525))+1)*t-s))+b}return c/2*((t-=2)*t*(((s*=(1.525))+1)*t+s)+2)+b},linear:function(x,t,b,c,d){return c*t/d+b}};
 (function($){$.fn.jCarouselLite=function(o){o=$.extend({btnPrev:null,btnNext:null,btnGo:null,mouseWheel:false,auto:null,speed:200,easing:null,vertical:false,circular:true,visible:3,start:0,scroll:1,beforeStart:null,afterEnd:null},o||{});return this.each(function(){var b=false,animCss=o.vertical?"top":"left",sizeCss=o.vertical?"height":"width";var c=$(this),ul=$("ul",c),tLi=$("li",ul),tl=tLi.size(),v=o.visible;if(o.circular){ul.prepend(tLi.slice(tl-v-1+1).clone()).append(tLi.slice(0,v).clone());o.start+=v}var f=$("li",ul),itemLength=f.size(),curr=o.start;c.css("visibility","visible");f.css({overflow:"hidden",float:o.vertical?"none":"left"});ul.css({margin:"0",padding:"0",position:"relative","list-style-type":"none","z-index":"1"});c.css({overflow:"hidden",position:"relative","z-index":"2",left:"0px"});var g=o.vertical?height(f):width(f);var h=g*itemLength;var j=g*v;f.css({width:f.width(),height:f.height()});ul.css(sizeCss,h+"px").css(animCss,-(curr*g));c.css(sizeCss,j+"px");if(o.btnPrev)$(o.btnPrev).click(function(){return go(curr-o.scroll)});if(o.btnNext)$(o.btnNext).click(function(){return go(curr+o.scroll)});if(o.btnGo)$.each(o.btnGo,function(i,a){$(a).click(function(){return go(o.circular?o.visible+i:i)})});if(o.mouseWheel&&c.mousewheel)c.mousewheel(function(e,d){return d>0?go(curr-o.scroll):go(curr+o.scroll)});if(o.auto)setInterval(function(){go(curr+o.scroll)},o.auto+o.speed);function vis(){return f.slice(curr).slice(0,v)};function go(a){if(!b){if(o.beforeStart)o.beforeStart.call(this,vis());if(o.circular){if(a<=o.start-v-1){ul.css(animCss,-((itemLength-(v*2))*g)+"px");curr=a==o.start-v-1?itemLength-(v*2)-1:itemLength-(v*2)-o.scroll}else if(a>=itemLength-v+1){ul.css(animCss,-((v)*g)+"px");curr=a==itemLength-v+1?v+1:v+o.scroll}else curr=a}else{if(a<0||a>itemLength-v)return;else curr=a}b=true;ul.animate(animCss=="left"?{left:-(curr*g)}:{top:-(curr*g)},o.speed,o.easing,function(){if(o.afterEnd)o.afterEnd.call(this,vis());b=false});if(!o.circular){$(o.btnPrev+","+o.btnNext).removeClass("disabled");$((curr-o.scroll<0&&o.btnPrev)||(curr+o.scroll>itemLength-v&&o.btnNext)||[]).addClass("disabled")}}return false}})};function css(a,b){return parseInt($.css(a[0],b))||0};function width(a){return a[0].offsetWidth+css(a,'marginLeft')+css(a,'marginRight')};function height(a){return a[0].offsetHeight+css(a,'marginTop')+css(a,'marginBottom')}})(jQuery);
 </script>
 
<ul>      	
	<?php foreach ($tour_hot_deals as $key => $tour):?>
		<li class="list_tour_hot_deals_content_li">
			<div class="deal_item">
				<div class="deal_item_price">
					<span class="b_discount"><?=CURRENCY_SYMBOL?><?=number_format($tour['from_price'], CURRENCY_DECIMAL)?></span>
					<span class="price_from" style="font-size:14px;"><?=CURRENCY_SYMBOL?><?=number_format($tour['selling_price'], CURRENCY_DECIMAL)?></span><br>
				</div>
				
				<div style="float: left;text-align: center; width: 100%;">				
					<a href="<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>"><img width="135" height="90" class="deal_item_image" src="<?=$this->config->item('tour_135_90_path').$tour['picture']?>" alt="<?=$tour['name']?>"></img></a>
				
					
					<div class="row">
						<a <?php if(strlen($tour['name']) > TOUR_NAME_HOT_DEAL_LIMIT):?> title="<?=$tour['name']?>" <?php endif;?> href="<?=url_builder(TOUR_DETAIL, $tour['url_title'], true)?>"><b><?=character_limiter($tour['name'], TOUR_NAME_HOT_DEAL_LIMIT)?></b></a><br/>				
					</div>
					
					<?php if ($tour['offer_note'] != ''):?>
						
							<?php 
								$offers = explode("\n", $tour['offer_note']);
							?>
							<?php foreach ($offers as $offer):?>
									<div class="row special"><span><?=$offer?></span></div>
							<?php endforeach;?>
							
					<?php endif;?>
				
				</div>
				
			</div>
		</li>	
	<?php endforeach;?>	
					
</ul>

<script type="text/javascript">
$(".list_tour_hot_deals_content").jCarouselLite({
    btnNext: ".list_tour_hot_deals_next",
    btnPrev: ".list_tour_hot_deals_prev",
    visible: 4,
    circular: false,
    scroll: 1
});
</script>

<?php endif;?>